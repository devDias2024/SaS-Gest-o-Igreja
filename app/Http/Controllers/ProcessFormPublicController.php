<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\MemberTag;
use App\Models\CellGroup;
use App\Models\CellMembership;
use App\Models\ProcessForm;
use App\Models\ProcessFormSubmission;
use App\Models\VisitorRegistration;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use Throwable;

class ProcessFormPublicController extends Controller
{
    public function preview(ProcessForm $processForm): View
    {
        return view('process-forms.show', [
            'form' => $processForm,
            'fields' => $this->fields($processForm),
            'preview' => true,
        ]);
    }

    public function show(string $slug): View
    {
        $form = ProcessForm::query()->published()->where('slug', $slug)->firstOrFail();

        abort_if($form->access_mode === 'members' && ! auth()->check(), 403);
        abort_if($form->hasReachedResponseLimit(), 403, 'Limite de respostas atingido.');

        return view('process-forms.show', ['form' => $form, 'fields' => $this->fields($form), 'preview' => false]);
    }

    public function store(Request $request, string $slug): RedirectResponse
    {
        $form = ProcessForm::query()->published()->where('slug', $slug)->firstOrFail();

        abort_if($form->access_mode === 'members' && ! auth()->check(), 403);
        abort_if($form->hasReachedResponseLimit(), 403, 'Limite de respostas atingido.');

        if ($form->captcha_enabled && filled($request->input('website'))) {
            return back()->with('status', 'Formulario enviado com sucesso.');
        }

        $validated = $request->validate($this->rules($form, $request), [], $this->labels($form));
        [$answers, $files] = $this->answersAndFiles($form, $request, $validated);

        $submission = ProcessFormSubmission::query()->create([
            'process_form_id' => $form->id,
            'member_id' => null,
            'submitter_name' => $this->answerFor($form, $answers, ['name_field', 'visitor_name_field', 'member_name_field'], 'nome'),
            'submitter_email' => $this->answerFor($form, $answers, ['email_field', 'visitor_email_field', 'member_email_field'], 'email'),
            'submitter_phone' => $this->answerFor($form, $answers, ['phone_field', 'visitor_phone_field', 'member_phone_field'], 'telefone'),
            'status' => 'pending',
            'answers' => $answers,
            'files' => $files,
            'submitted_at' => now(),
            'ip_address' => $request->ip(),
            'user_agent' => (string) $request->userAgent(),
        ]);

        $this->applyMappings($form, $submission, $answers);
        $this->dispatchAutomations($form, $submission);
        $this->dispatchWebhooks($form, $submission);

        if (filled($form->redirect_url)) {
            return redirect()->away($form->redirect_url);
        }

        return back()->with('status', $form->confirmation_message ?: 'Formulario enviado com sucesso.');
    }

    protected function rules(ProcessForm $form, Request $request): array
    {
        $rules = [];

        foreach ($this->fields($form) as $field) {
            $data = $field['data'];
            $key = $data['key'];
            $fieldRules = [];

            if (($data['required'] ?? false) && $this->conditionMatches($data, $request)) {
                $fieldRules[] = $field['type'] === 'agreement' ? 'accepted' : 'required';
            } else {
                $fieldRules[] = 'nullable';
            }

            $fieldRules[] = match ($field['type']) {
                'email' => 'email',
                'number' => 'numeric',
                'file_upload' => 'file|max:10240',
                'multi_choice' => 'array',
                default => 'string',
            };

            if ($field['type'] === 'multi_choice') {
                $rules[$key . '.*'] = ['string'];
            }

            $rules[$key] = $fieldRules;
        }

        return $rules;
    }

    protected function answersAndFiles(ProcessForm $form, Request $request, array $validated): array
    {
        $answers = [];
        $files = [];

        foreach ($this->fields($form) as $field) {
            $data = $field['data'];
            $key = $data['key'];

            if ($field['type'] === 'file_upload' && $request->hasFile($key)) {
                $files[$key] = $request->file($key)->store('process-forms/' . $form->id, 'public');
                $answers[$key] = $files[$key];

                continue;
            }

            $answers[$key] = $validated[$key] ?? null;
        }

        return [$answers, $files];
    }

    protected function applyMappings(ProcessForm $form, ProcessFormSubmission $submission, array $answers): void
    {
        $mappings = $form->mappings ?? [];

        if ($this->truthy($mappings['create_visitor_registration'] ?? null)) {
            $visitor = VisitorRegistration::query()->create([
                'name' => $answers[$mappings['visitor_name_field'] ?? 'nome'] ?? $submission->submitter_name,
                'email' => $answers[$mappings['visitor_email_field'] ?? 'email'] ?? $submission->submitter_email,
                'phone' => $answers[$mappings['visitor_phone_field'] ?? 'telefone'] ?? $submission->submitter_phone,
                'status' => 'new',
                'notes' => 'Criado pelo formulario: ' . $form->title,
                'metadata' => ['process_form_submission_id' => $submission->id],
            ]);

            $submission->update(['visitor_registration_id' => $visitor->id]);
        }

        if ($this->truthy($mappings['create_or_update_member'] ?? null)) {
            $email = $answers[$mappings['member_email_field'] ?? 'email'] ?? $submission->submitter_email;
            $member = Member::query()->updateOrCreate(
                ['email' => $email],
                [
                    'full_name' => $answers[$mappings['member_name_field'] ?? 'nome'] ?? $submission->submitter_name ?? 'Cadastro sem nome',
                    'phone' => $answers[$mappings['member_phone_field'] ?? 'telefone'] ?? $submission->submitter_phone,
                    'whatsapp' => $answers[$mappings['member_phone_field'] ?? 'telefone'] ?? $submission->submitter_phone,
                ],
            );

            if (filled($mappings['member_tag'] ?? null)) {
                $tag = MemberTag::query()->firstOrCreate(['name' => $mappings['member_tag']], ['color' => 'primary']);
                $member->tags()->syncWithoutDetaching([$tag->id]);
            }

            if (filled($mappings['cell_group_name'] ?? null)) {
                $cellGroup = CellGroup::query()->firstOrCreate(
                    ['name' => $mappings['cell_group_name']],
                    ['status' => 'active'],
                );

                CellMembership::query()->firstOrCreate(
                    ['cell_group_id' => $cellGroup->id, 'member_id' => $member->id],
                    ['status' => 'active', 'role' => 'participant', 'joined_on' => now()->toDateString()],
                );
            }

            $submission->update(['member_id' => $member->id]);
        }
    }

    protected function dispatchAutomations(ProcessForm $form, ProcessFormSubmission $submission): void
    {
        $automations = $form->automations ?? [];

        if (filled($submission->submitter_email) && filled($automations['confirmation_email_subject'] ?? null)) {
            try {
                Mail::raw($automations['confirmation_email_body'] ?? 'Recebemos sua resposta.', function ($message) use ($submission, $automations): void {
                    $message->to($submission->submitter_email)->subject($automations['confirmation_email_subject']);
                });
            } catch (Throwable) {
                report('Falha ao enviar e-mail de confirmacao do formulario.');
            }
        }

        if (filled($automations['notify_email'] ?? null)) {
            try {
                Mail::raw('Nova resposta recebida no formulario ' . $form->title, function ($message) use ($automations, $form): void {
                    $message->to($automations['notify_email'])->subject('Nova resposta: ' . $form->title);
                });
            } catch (Throwable) {
                report('Falha ao notificar responsavel pelo formulario.');
            }
        }

        if (filled($automations['whatsapp_message'] ?? null)) {
            $submission->update([
                'internal_notes' => trim(($submission->internal_notes ? $submission->internal_notes."\n\n" : '').'WhatsApp automatico pendente: '.$automations['whatsapp_message']),
            ]);
        }
    }

    protected function dispatchWebhooks(ProcessForm $form, ProcessFormSubmission $submission): void
    {
        foreach ($form->webhooks ?? [] as $webhook) {
            if (! ($webhook['is_active'] ?? true) || blank($webhook['url'] ?? null)) {
                continue;
            }

            try {
                Http::timeout(5)
                    ->withHeaders(filled($webhook['secret'] ?? null) ? ['X-Process-Form-Secret' => $webhook['secret']] : [])
                    ->send($webhook['method'] ?? 'POST', $webhook['url'], [
                        'json' => [
                            'form' => $form->only(['id', 'title', 'slug']),
                            'submission' => $submission->fresh()->toArray(),
                        ],
                    ]);
            } catch (Throwable) {
                report('Falha ao enviar webhook do formulario.');
            }
        }
    }

    protected function fields(ProcessForm $form): array
    {
        return collect($form->fields ?? [])
            ->map(fn (array $field) => ['type' => $field['type'] ?? 'short_text', 'data' => $field['data'] ?? []])
            ->filter(fn (array $field) => filled($field['data']['key'] ?? null) && filled($field['data']['label'] ?? null))
            ->values()
            ->all();
    }

    protected function labels(ProcessForm $form): array
    {
        return collect($this->fields($form))->mapWithKeys(fn (array $field) => [$field['data']['key'] => $field['data']['label']])->all();
    }

    protected function answerFor(ProcessForm $form, array $answers, array $mappingKeys, string $fallbackKey): mixed
    {
        $mappings = $form->mappings ?? [];

        foreach ($mappingKeys as $mappingKey) {
            if (filled($mappings[$mappingKey] ?? null) && array_key_exists($mappings[$mappingKey], $answers)) {
                return $answers[$mappings[$mappingKey]];
            }
        }

        return $answers[$fallbackKey] ?? null;
    }

    protected function conditionMatches(array $data, Request $request): bool
    {
        if (blank($data['conditional_field'] ?? null)) {
            return true;
        }

        return (string) $request->input($data['conditional_field']) === (string) ($data['conditional_value'] ?? '');
    }

    protected function truthy(mixed $value): bool
    {
        return in_array($value, [true, 1, '1', 'true', 'on', 'yes', 'sim'], true);
    }
}
