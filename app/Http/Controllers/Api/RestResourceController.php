<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Asset;
use App\Models\BlogPost;
use App\Models\ChildCheckIn;
use App\Models\ChildProfile;
use App\Models\ChurchEvent;
use App\Models\DietaryRestriction;
use App\Models\DiningMenu;
use App\Models\EventCheckIn;
use App\Models\EventRegistration;
use App\Models\FinancialPledge;
use App\Models\FinancialTransaction;
use App\Models\FoodDonation;
use App\Models\MealService;
use App\Models\Member;
use App\Models\MemberCategory;
use App\Models\MemberCredential;
use App\Models\MemberCredentialTemplate;
use App\Models\MemberTag;
use App\Models\OnlineDonation;
use App\Models\PastoralCounselingCase;
use App\Models\PastoralCounselingSession;
use App\Models\ProcessForm;
use App\Models\ProcessFormSubmission;
use App\Models\Sermon;
use App\Models\SitePage;
use App\Models\SocialPantryDistribution;
use App\Models\StockMovement;
use App\Models\SundaySchoolAttendance;
use App\Models\SundaySchoolCertificate;
use App\Models\SundaySchoolClass;
use App\Models\SundaySchoolEnrollment;
use App\Models\SundaySchoolGrade;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RestResourceController extends Controller
{
    private const RESOURCES = [
        'members' => Member::class,
        'member-categories' => MemberCategory::class,
        'member-tags' => MemberTag::class,
        'member-credentials' => MemberCredential::class,
        'member-credential-templates' => MemberCredentialTemplate::class,
        'financial-transactions' => FinancialTransaction::class,
        'financial-pledges' => FinancialPledge::class,
        'online-donations' => OnlineDonation::class,
        'events' => ChurchEvent::class,
        'event-registrations' => EventRegistration::class,
        'event-checkins' => EventCheckIn::class,
        'child-profiles' => ChildProfile::class,
        'child-checkins' => ChildCheckIn::class,
        'forms' => ProcessForm::class,
        'form-submissions' => ProcessFormSubmission::class,
        'counseling-cases' => PastoralCounselingCase::class,
        'counseling-sessions' => PastoralCounselingSession::class,
        'sunday-school-classes' => SundaySchoolClass::class,
        'sunday-school-enrollments' => SundaySchoolEnrollment::class,
        'sunday-school-attendances' => SundaySchoolAttendance::class,
        'sunday-school-grades' => SundaySchoolGrade::class,
        'sunday-school-certificates' => SundaySchoolCertificate::class,
        'assets' => Asset::class,
        'stock-movements' => StockMovement::class,
        'dining-menus' => DiningMenu::class,
        'meal-services' => MealService::class,
        'dietary-restrictions' => DietaryRestriction::class,
        'food-donations' => FoodDonation::class,
        'social-pantry-distributions' => SocialPantryDistribution::class,
        'sermons' => Sermon::class,
        'blog-posts' => BlogPost::class,
        'site-pages' => SitePage::class,
    ];

    public function index(Request $request, string $resource): JsonResponse
    {
        $model = $this->model($resource);
        $perPage = min(max((int) $request->integer('per_page', 25), 1), 100);

        return response()->json($model::query()->latest('id')->paginate($perPage));
    }

    public function show(string $resource, int $id): JsonResponse
    {
        $model = $this->model($resource);

        return response()->json($model::query()->findOrFail($id));
    }

    public function store(Request $request, string $resource): JsonResponse
    {
        $model = $this->model($resource);
        $record = $model::query()->create($this->fillableData(new $model, $request));

        return response()->json($record->fresh(), 201);
    }

    public function update(Request $request, string $resource, int $id): JsonResponse
    {
        $model = $this->model($resource);
        $record = $model::query()->findOrFail($id);
        $record->update($this->fillableData($record, $request));

        return response()->json($record->fresh());
    }

    public function destroy(string $resource, int $id): JsonResponse
    {
        $model = $this->model($resource);
        $model::query()->findOrFail($id)->delete();

        return response()->json(['deleted' => true]);
    }

    private function model(string $resource): string
    {
        abort_unless(array_key_exists($resource, self::RESOURCES), 404, 'Recurso nao encontrado.');

        return self::RESOURCES[$resource];
    }

    private function fillableData(Model $model, Request $request): array
    {
        return collect($request->all())
            ->only($model->getFillable())
            ->all();
    }
}
