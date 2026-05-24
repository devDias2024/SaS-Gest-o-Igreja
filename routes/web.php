<?php

use App\Http\Controllers\ChildCheckInLabelController;
use App\Http\Controllers\EventCheckInController;
use App\Http\Controllers\MemberCredentialController;
use App\Http\Controllers\PastoralCounselingReportController;
use App\Http\Controllers\ProcessFormDashboardController;
use App\Http\Controllers\ProcessFormPublicController;
use App\Http\Controllers\PublicSiteController;
use App\Http\Controllers\SaasSiteController;
use App\Http\Controllers\SermonShareController;
use App\Http\Controllers\SiteLiveChatController;
use App\Http\Controllers\SocialPantryReportController;
use App\Http\Controllers\SundaySchoolCertificateController;
use App\Http\Controllers\SundaySchoolReportController;
use Illuminate\Support\Facades\Route;

Route::get('/', [SaasSiteController::class, 'home'])->name('saas.home');
Route::get('/planos', [SaasSiteController::class, 'plans'])->name('saas.plans');
Route::get('/plans', [SaasSiteController::class, 'plans'])->name('saas.plans.en');
Route::get('/blog', [SaasSiteController::class, 'blog'])->name('saas.blog');
Route::get('/blog/{slug}', [SaasSiteController::class, 'blogPost'])->name('saas.blog.show');
Route::get('/ajuda', [SaasSiteController::class, 'help'])->name('saas.help');
Route::get('/help', [SaasSiteController::class, 'help'])->name('saas.help.en');
Route::get('/suporte/novo', [SaasSiteController::class, 'support'])->name('saas.support');
Route::post('/suporte/novo', [SaasSiteController::class, 'storeSupport'])->name('saas.support.store');

Route::get('/igreja', [PublicSiteController::class, 'home'])->name('public.home');
Route::get('/igreja/agenda', [PublicSiteController::class, 'events'])->name('public.events');
Route::get('/igreja/pregacoes', [PublicSiteController::class, 'sermons'])->name('public.sermons');
Route::get('/igreja/blog', [PublicSiteController::class, 'blog'])->name('public.blog');
Route::get('/igreja/blog/{slug}', [PublicSiteController::class, 'blogPost'])->name('public.blog.show');
Route::post('/igreja/doacoes', [PublicSiteController::class, 'storeDonation'])->name('public.donations.store');
Route::post('/igreja/contato', [PublicSiteController::class, 'storeContact'])->name('public.contacts.store');
Route::post('/igreja/visitantes', [PublicSiteController::class, 'storeVisitor'])->name('public.visitors.store');
Route::get('/site/chat-ao-vivo', [SiteLiveChatController::class, 'index'])->name('public.live-chat.index');
Route::post('/site/chat-ao-vivo', [SiteLiveChatController::class, 'store'])->name('public.live-chat.store');
Route::post('/site/chat-ao-vivo/presenca', [SiteLiveChatController::class, 'heartbeat'])->name('public.live-chat.heartbeat');
Route::get('/formularios/{slug}', [ProcessFormPublicController::class, 'show'])->name('process-forms.show');
Route::post('/formularios/{slug}', [ProcessFormPublicController::class, 'store'])->name('process-forms.store');
Route::get('/admin/process-forms/{processForm}/dashboard', [ProcessFormDashboardController::class, 'show'])
    ->middleware('auth')
    ->name('process-forms.dashboard');
Route::get('/admin/process-forms/{processForm}/preview', [ProcessFormPublicController::class, 'preview'])
    ->middleware('auth')
    ->name('process-forms.preview');
Route::get('/admin/pastoral-counseling/reports/demand', [PastoralCounselingReportController::class, 'demand'])
    ->middleware('auth')
    ->name('pastoral-counseling.reports.demand');
Route::get('/admin/escola-dominical/certificados/{certificate}/imprimir', [SundaySchoolCertificateController::class, 'print'])
    ->middleware('auth')
    ->name('sunday-school.certificates.print');
Route::get('/admin/escola-dominical/membros/{member}/historico', [SundaySchoolCertificateController::class, 'history'])
    ->middleware('auth')
    ->name('sunday-school.members.history');
Route::get('/admin/escola-dominical/relatorios/aprovacao', [SundaySchoolReportController::class, 'approvals'])
    ->middleware('auth')
    ->name('sunday-school.reports.approvals');
Route::get('/admin/refeitorio-despensa/relatorios/publico', [SocialPantryReportController::class, 'audience'])
    ->middleware('auth')
    ->name('social-pantry.reports.audience');
Route::get('/certificados/escola-dominical/{token}', [SundaySchoolCertificateController::class, 'validateCertificate'])
    ->name('sunday-school.certificates.validate');
Route::get('/admin/membros/credenciais/{credential}/imprimir', [MemberCredentialController::class, 'print'])
    ->middleware('auth')
    ->name('credentials.print');
Route::get('/admin/membros/modelos-credenciais/{template}/previa', [MemberCredentialController::class, 'previewTemplate'])
    ->middleware('auth')
    ->name('credentials.templates.preview');
Route::get('/credenciais/{token}', [MemberCredentialController::class, 'validateCredential'])
    ->name('credentials.validate');

Route::get('/eventos/check-in/{token}', [EventCheckInController::class, 'show'])
    ->name('events.check-in.show');

Route::get('/admin/check-in-infantil/{childCheckIn}/etiqueta', [ChildCheckInLabelController::class, 'show'])
    ->middleware('auth')
    ->name('children.check-in.label');

Route::get('/eventos/check-in/{token}/qr', [EventCheckInController::class, 'qr'])
    ->name('events.check-in.qr');

Route::post('/eventos/check-in/{token}', [EventCheckInController::class, 'store'])
    ->name('events.check-in.store');

Route::get('/pregacoes/{token}', [SermonShareController::class, 'show'])
    ->name('sermons.share.show');

Route::get('/pregacoes/{token}/midias/{media}/download', [SermonShareController::class, 'download'])
    ->name('sermons.share.download');

Route::get('/igreja/paginas/{slug}', [PublicSiteController::class, 'page'])->name('public.pages.show');
