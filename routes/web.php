<?php

use Illuminate\Support\Str;
use Spatie\Csp\AddCspHeaders;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Livewire\Admin\Site\Index as site;
use App\Http\Controllers\ProfileController;
use App\Livewire\Admin\People\Index as people;
use App\Livewire\Admin\People\Show as peopleShow;
use App\Livewire\Dashboard\Index  as dashoard;
use App\Livewire\Admin\Company\Index as company;
use App\Livewire\Admin\Section\Index as section;
use App\Livewire\Admin\Division\Inde as division;
use App\Livewire\Admin\DeptByBU\Index as DeptByBU;
use App\Livewire\Admin\JobClass\Index as JobClass;
use App\Livewire\Admin\Location\Index as Location;
use App\Livewire\Admin\DeptGroup\Index as deptGroup;
use App\Livewire\Admin\Workgroup\Index as workgroup;
use App\Livewire\Manhours\Index as manhoursRegister;

use App\Livewire\Manhours\WebAccess;

use App\Livewire\ManhoursSite\Index as manhoursSite;
use App\Livewire\Admin\Department\Index as department;
use App\Livewire\Admin\SubConDept\Index as subContDept;
use App\Livewire\Admin\StatusEvent\Index as StatusEvent;
use App\Livewire\EventReport\PtoReport\Create as PTOForm;
use App\Livewire\Admin\BusinessUnit\Index as businnesUnit;
use App\Livewire\Admin\EventSubType\Index as eventSubType;
use App\Livewire\EventReport\PtoReport\Index as ptoReport;
use App\Livewire\Admin\KeywordMaintenance\Index as keyWord;
use App\Livewire\EventReport\PtoReport\Detail as ptoDetail;
use App\Livewire\Admin\EventCategory\Index as EventCategory;
use App\Livewire\Admin\RiskAssessment\Index as RiskAssessment;
use App\Livewire\Admin\RiskLikelihood\Index as RiskLikelihood;
use App\Livewire\Admin\RouteRequest\Index as routeRequestEvent;
use App\Livewire\Admin\ChoseEventType\Index as choseEventType;
use App\Livewire\Admin\CompanyCategory\Index as categoryCompany;
use App\Livewire\Admin\ResponsibleRole\Index as responsibleRole;
use App\Livewire\Admin\RiskConsequence\Index as RiskConsequence;
use App\Livewire\Admin\TypeEventReport\Index as typeEventReport;
use App\Livewire\Admin\TypeInvolvement\Index as typeInvolvement;
use App\Livewire\EventReport\HazardReport\Index as hazardReport;
use App\Livewire\Admin\EventUserSecurity\Index as eventUserSecurity;
use App\Livewire\EventReport\IncidentReport\Index as IncidentReport;
use App\Livewire\EventReport\HazardReport\Detail as hazardReportDetail;
use App\Livewire\Admin\TableRiskAssessment\Index as TableRiskAssessment;
use App\Livewire\Admin\UserInputManhours\Index as userInputManhours;
use App\Livewire\EventReport\IncidentReport\Detail as incidentReportDetail;
use App\Livewire\Admin\WorkflowAdministration\Index as workflowAdministration;
use App\Livewire\EventReport\HazardReport\CreateAndUpdate as hazardReportform;
use App\Livewire\EventReport\HazardReportGuest\Create as HazardReportGuestCreate;
use App\Livewire\EventReport\IncidentReport\CreateAndUpdate as CreateAndUpdateIncidentReport;


// $newReference =  Str::random(9);
// $reference_pto = 'OHS-PTO-' . $newReference;

Route::get('/language/{locale}', function ($locale) {
    if (! in_array($locale, ['en', 'id'])) {
        abort(400);
    }
    session()->put('locale', $locale);
    return redirect()->back();
})->name('locale');

Route::get(
    '/welcome',
    function () {
        return view('welcome');
    }
);
Route::get('/config-clear', function () {
    $exitCode = Artisan::call('config:clear');
    return '<h1>Clear Config cleared</h1>';
});
Route::get('eventReport/hazardReportform/{workflow_template_id?}', hazardReportform::class)->name('hazardReportform');
Route::get('eventReport/hazardReportGuest/{workflow_template_id?}', HazardReportGuestCreate::class)->name('hazardReportCreate');
Route::get('manhours/manhoursTable', WebAccess::class)->name('WebAccess');
Route::middleware(['auth', 'auth.session'])->group(function () {

    Route::get('/', dashoard::class)->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::group(['middleware' => 'admin'], function () {
        Route::get('admin/parent/companyCategory', categoryCompany::class)->name('categoryCompany');
        Route::get('admin/parent/company', company::class)->name('company');
        Route::get('admin/parent/businnesUnit', businnesUnit::class)->name('businnesUnit');
        Route::get('admin/parent/department', department::class)->name('department');
        Route::get('admin/parent/deptGroup', deptGroup::class)->name('deptGroup');
        Route::get('admin/parent/subContDept', subContDept::class)->name('subContDept');
        Route::get('admin/parent/DeptByBU', DeptByBU::class)->name('DeptByBU');
        Route::get('admin/parent/JobClass', JobClass::class)->name('JobClass');
        Route::get('admin/parent/workgroup', workgroup::class)->name('workgroup');
        Route::get('admin/parent/statusEvent', StatusEvent::class)->name('statusEvent');
        Route::get('admin/parent/riskConsequence', RiskConsequence::class)->name('riskConsequence');
        Route::get('admin/parent/riskAssessment', RiskAssessment::class)->name('riskAssessment');
        Route::get('admin/parent/riskLikelihood', RiskLikelihood::class)->name('riskLikelihood');
        Route::get('admin/parent/tableRiskAssessment', TableRiskAssessment::class)->name('tableRiskAssessment');
        Route::get('admin/parent/location', Location::class)->name('location');
        Route::get('admin/parent/event/eventCategory', EventCategory::class)->name('eventCategory');
        Route::get('admin/parent/event/typeEventReport', typeEventReport::class)->name('typeEventReport');
        Route::get('admin/parent/event/eventSubType', eventSubType::class)->name('eventSubType');
        Route::get('admin/parent/event/responsibleRole', responsibleRole::class)->name('responsibleRole');
        Route::get('admin/parent/event/eventUserSecurity', eventUserSecurity::class)->name('eventUserSecurity');
        Route::get('admin/parent/site', site::class)->name('site');
        Route::get('admin/parent/division', division::class)->name('division');
        Route::get('admin/parent/workflowAdministration', workflowAdministration::class)->name('workflowAdministration');
        Route::get('admin/parent/typeInvolvement', typeInvolvement::class)->name('typeInvolvement');
        Route::get('admin/parent/section', section::class)->name('section');
        Route::get('admin/parent/keyWord', keyWord::class)->name('keyWord');
        Route::get('admin/parent/routeRequestEvent', routeRequestEvent::class)->name('routeRequestEvent');
        Route::get('admin/parent/choseEventType', choseEventType::class)->name('choseEventType');
        Route::get('admin/parent/userInputManhours', userInputManhours::class)->name('userInputManhours');
        Route::get('manhours/manhoursSite', manhoursSite::class)->name('manhoursSite');
        // people
        Route::get('admin/people', people::class)->name('people');
        Route::get('admin/people/show/{id}', peopleShow::class)->name('peopleShow');
    });


    // event report Incident route
    Route::get('eventReport/incidentReport', IncidentReport::class)->name('incidentReport');
    Route::get('eventReport/incidentReportsform/{workflow_template_id?}', CreateAndUpdateIncidentReport::class)->name('incidentReportform');
    Route::get('eventReport/incidentReportDetail/{id}', incidentReportDetail::class)->name('incidentReportDetail');
    // event report Hazard route
    Route::get('eventReport/hazardReport', hazardReport::class)->name('hazardReport');
    Route::get('eventReport/hazardReportDetail/{id}', hazardReportDetail::class)->name('hazardReportDetail');

    // event report pto route
    Route::get('eventReport/PTOReport', ptoReport::class)->name('ptoReport');
    Route::get('eventReport/PTOReport/detail/{id}', ptoDetail::class)->name('ptoDetail');
    Route::get('eventReport/PTOReport/form/{reference?}/{workflow_template_id?}', PTOForm::class)->name('ptoForm');

    // Manhours

    Route::get('manhours/manhoursRegister', manhoursRegister::class)->name('manhoursRegister');
});

Route::fallback(function () {
    return view('404');
});

require __DIR__ . '/auth.php';
