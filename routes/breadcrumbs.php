
<?php // routes/breadcrumbs.php

// Note: Laravel will automatically resolve `Breadcrumbs::` without
// this import. This is nice for IDE syntax and refactoring.

use App\Models\HazardReport;
use App\Models\IncidentReport;
use App\Models\pto_report;
use Diglactic\Breadcrumbs\Breadcrumbs;

// This import is also not required, and you could replace `BreadcrumbTrail $trail`
//  with `$trail`. This is nice for IDE type checking and completion.
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// Home
Breadcrumbs::for('dashboard', function (BreadcrumbTrail $trail) {
    $trail->push('Home', route('dashboard'));
});

// Home > Blog
Breadcrumbs::for('incidentReport', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Incident Report', route('incidentReport'));
});

// Home > Blog > [Category]
Breadcrumbs::for('incidentReportform', function (BreadcrumbTrail $trail, ) {
    $trail->parent('incidentReport');
    $trail->push('Create', route('incidentReportform'));
});
Breadcrumbs::for('incidentReportDetail', function (BreadcrumbTrail $trail, $id ) {
    $trail->parent('incidentReport');
    $trail->push(IncidentReport::whereId($id)->first()->reference, route('incidentReportDetail',$id));
});

Breadcrumbs::for('hazardReport', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Hazard Report', route('hazardReport'));
});
Breadcrumbs::for('hazardReportform', function (BreadcrumbTrail $trail) {
    $trail->parent('hazardReport');
    $trail->push('Create', route('hazardReportform'));
});
Breadcrumbs::for('hazardReportDetail', function (BreadcrumbTrail $trail, $id ) {
    $trail->parent('hazardReport');
    $trail->push(HazardReport::whereId($id)->first()->reference, route('hazardReportDetail',$id));
});
Breadcrumbs::for('ptoReport', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('PTO Report', route('ptoReport'));
});
Breadcrumbs::for('PtoReportform', function (BreadcrumbTrail $trail) {
    $trail->parent('ptoReport');
    $trail->push('Create', route('ptoForm'));
});
Breadcrumbs::for('PtoReportDetail', function (BreadcrumbTrail $trail,$id) {
    $trail->parent('ptoReport');
    $trail->push(pto_report::whereId($id)->first()->reference, route('ptoDetail',$id));
});
