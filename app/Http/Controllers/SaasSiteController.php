<?php

namespace App\Http\Controllers;

use App\Models\PublicContact;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SaasSiteController extends Controller
{
    public function home(): View
    {
        return view('saas-site.home', [
            'modules' => $this->modules(),
            'posts' => array_slice($this->posts(), 0, 3),
        ]);
    }

    public function plans(): View
    {
        return view('saas-site.plans', [
            'plans' => $this->plansData(),
        ]);
    }

    public function blog(): View
    {
        return view('saas-site.blog', [
            'posts' => $this->posts(),
        ]);
    }

    public function blogPost(string $slug): View
    {
        $post = collect($this->posts())->firstWhere('slug', $slug);

        abort_unless($post, 404);

        return view('saas-site.blog-post', [
            'post' => $post,
            'posts' => array_values(array_filter(
                $this->posts(),
                fn (array $item): bool => $item['slug'] !== $slug,
            )),
        ]);
    }

    public function help(): View
    {
        return view('saas-site.help', [
            'categories' => $this->helpCategories(),
        ]);
    }

    public function support(): View
    {
        return view('saas-site.support');
    }

    public function storeSupport(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'email' => ['required', 'email', 'max:255'],
            'name' => ['nullable', 'string', 'max:255'],
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:5000'],
        ]);

        PublicContact::query()->create([
            'name' => $data['name'] ?: $data['email'],
            'email' => $data['email'],
            'subject' => $data['subject'],
            'message' => $data['message'],
            'source' => 'saas_support',
            'status' => 'new',
            'metadata' => [
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ],
        ]);

        return back()->with('status', 'Ticket enviado. Nossa equipe vai responder em breve.');
    }

    private function modules(): array
    {
        return [
            ['title' => 'Membros e visitantes', 'text' => 'Cadastro completo, carteirinha digital, famílias, tags, aniversários e histórico pastoral.'],
            ['title' => 'Financeiro e doações', 'text' => 'Dízimos, ofertas, fundos, recibos, conciliação, metas e relatórios prontos para decisão.'],
            ['title' => 'Eventos e check-in', 'text' => 'Agenda, inscrições, QR Code, check-in universal, geofence, offline e escala de voluntários.'],
            ['title' => 'Células e ministérios', 'text' => 'Grupos, líderes, presença, multiplicação, metas ministeriais e acompanhamento por rede.'],
            ['title' => 'Ensino e certificações', 'text' => 'Escola dominical, turmas, frequência, notas, certificados com QR Code e histórico escolar.'],
            ['title' => 'Site público e app', 'text' => 'Editor visual, blog, agenda, pregações, formulários públicos, chat ao vivo e conteúdo no celular.'],
            ['title' => 'Process builder', 'text' => 'Formulários com campos condicionais, automações, webhooks, respostas e exportações.'],
            ['title' => 'Social e segurança', 'text' => 'Check-in infantil, aconselhamento sigiloso, despensa social, refeições e relatórios de atendimento.'],
            ['title' => 'API e integrações', 'text' => 'API pública, chaves, rate limit, logs e webhooks para conectar CRM, planilhas, n8n e Zapier.'],
        ];
    }

    private function plansData(): array
    {
        return [
            ['name' => 'Starter', 'price' => 'R$ 0', 'note' => 'para começar', 'featured' => false, 'features' => ['30 membros', 'Site público', 'Agenda básica', '3 formulários', 'Suporte por e-mail']],
            ['name' => 'Prata', 'price' => 'R$ 84', 'note' => 'por mês', 'featured' => true, 'features' => ['250 membros', 'Financeiro completo', 'Eventos com check-in', 'Células e ministérios', '20 GB de arquivos']],
            ['name' => 'Ouro', 'price' => 'R$ 99', 'note' => 'por mês', 'featured' => false, 'features' => ['500 membros', 'API e webhooks', 'Escola dominical', 'Aconselhamento pastoral', 'Relatórios avançados']],
            ['name' => 'Diamante', 'price' => 'R$ 149', 'note' => 'por mês', 'featured' => false, 'features' => ['Membros ilimitados', 'Multi-equipe', 'Automações avançadas', 'Suporte prioritário', 'Treinamento incluso']],
        ];
    }

    private function posts(): array
    {
        return [
            ['slug' => 'organizar-ministerios-plataforma', 'category' => 'Gestão de igrejas', 'title' => 'Como organizar todos os ministérios em uma única plataforma', 'excerpt' => 'Centralize membros, líderes, eventos, finanças e comunicação sem perder a simplicidade.', 'image' => 'https://picsum.photos/seed/igreja-gestao/640/420'],
            ['slug' => 'check-in-qr-code-culto', 'category' => 'Eventos', 'title' => 'Check-in com QR Code: menos fila e mais segurança no culto', 'excerpt' => 'Veja como o check-in universal ajuda recepção, voluntários e relatórios de presença.', 'image' => 'https://picsum.photos/seed/igreja-eventos/640/420'],
            ['slug' => 'boas-praticas-dizimos-ofertas', 'category' => 'Financeiro', 'title' => 'Boas práticas para dízimos, ofertas e prestação de contas', 'excerpt' => 'Rotinas simples para relatórios claros e decisões financeiras mais tranquilas.', 'image' => 'https://picsum.photos/seed/igreja-financeiro/640/420'],
            ['slug' => 'seguranca-check-in-infantil', 'category' => 'Ministério infantil', 'title' => 'Segurança no check-in infantil: etiquetas, responsáveis e retirada', 'excerpt' => 'Um fluxo seguro para crianças, pais, voluntários e liderança.', 'image' => 'https://picsum.photos/seed/igreja-kids/640/420'],
            ['slug' => 'automatizar-inscricoes-cadastros', 'category' => 'Formulários', 'title' => 'Automatize inscrições, pedidos e cadastros sem código', 'excerpt' => 'Use templates e automações para transformar respostas em ações no sistema.', 'image' => 'https://picsum.photos/seed/igreja-forms/640/420'],
            ['slug' => 'certificados-digitais-qr-code', 'category' => 'Ensino', 'title' => 'Certificados digitais com QR Code para cursos da igreja', 'excerpt' => 'Organize turmas, notas, frequência e certificados em poucos passos.', 'image' => 'https://picsum.photos/seed/igreja-ensino/640/420'],
        ];
    }

    private function helpCategories(): array
    {
        return [
            'Pessoas' => ['Adicionar um membro', 'Criar famílias e vínculos', 'Emitir cartão de membro'],
            'Grupos' => ['Criar uma célula', 'Adicionar líderes', 'Lançar frequência'],
            'Ensino' => ['Cadastrar uma turma', 'Lançar notas', 'Emitir certificados'],
            'Financeiro' => ['Registrar dízimos', 'Gerar recibos', 'Ver relatórios'],
            'Agenda' => ['Adicionar evento', 'Gerar QR Code', 'Sincronizar check-in offline'],
            'Configurações' => ['Editar dados da igreja', 'Criar chave de API', 'Cadastrar webhook'],
        ];
    }
}
