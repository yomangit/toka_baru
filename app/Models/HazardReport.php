<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HazardReport extends Model
{
    use HasFactory;
    protected $table = 'hazard_reports';
    protected $fillable = [
        'reference',
        'event_type_id',
        'sub_event_type_id',
        'potential_lti',
        'division_id',
        'workgroup_name',
        'report_by',
        'report_byName',
        'report_to',
        'report_toName',
        'date',
        'site_id',
        'company_involved',
        'task_being_done',
        'documentation',
        'description',
        'location_name',
        'immediate_corrective_action',
        'suggested_corrective_action',
        'corrective_action_suggested',
        'risk_probability_id',
        'risk_consequence_id',
        'risk_likelihood_id',
        'report_by_nolist',
        'report_to_nolist',
        'moderator',
        'status',
        'closed_by',
        'workflow_template_id',
        'responsible_manager',
        'workflow_detail_id',
        'assign_to',
        'also_assign_to',
        'comments',
        'kondisi_tidak_aman',
        'tindakkan_selanjutnya',
        'show_immidiate',
        'submitter'
    ];
    public function riskConsequence()
    {
        return $this->belongsTo(RiskConsequence::class);
    }
    public function riskLikelihood()
    {
        return $this->belongsTo(RiskLikelihood::class);
    }
    public function eventType()
    {
        return $this->belongsTo(TypeEventReport::class, 'event_type_id');
    }
    public function subEventType()
    {
        return $this->belongsTo(Eventsubtype::class, 'sub_event_type_id');
    }

    public function Site()
    {
        return $this->belongsTo(Site::class, 'site_id');
    }
    public function eventLocation()
    {
        return $this->belongsTo(LocationEvent::class, 'event_location_id');
    }
    public function closedBy()
    {
        return $this->belongsTo(User::class, 'closed_by');
    }
    public function responsibleManager()
    {
        return $this->belongsTo(User::class, 'responsible_manager');
    }
    public function reportBy()
    {
        return $this->belongsTo(User::class, 'report_by');
    }
    public function reportsTo()
    {
        return $this->belongsTo(User::class, 'report_to');
    }
    public function WorkflowDetails()
    {
        return $this->belongsTo(WorkflowDetail::class, 'workflow_detail_id');
    }

    public function Assign_to()
    {
        return $this->belongsTo(User::class, 'assign_to');
    }
    public function Submitter()
    {
        return $this->belongsTo(User::class, 'submitter');
    }
    public function Also_assign_to()
    {
        return $this->belongsTo(User::class, 'also_assign_to');
    }

    public function scopeSearchStatus($query, $term)
    {
        $query->when(
            $term ?? false,
            fn($query, $term) =>
            $query->whereHas('WorkflowDetails', function ($q) use ($term) {
                $q->whereHas('Status', function ($q) use ($term) {
                    $q->where('status_name', 'like', '%' . $term . '%');
                });
            })
        );
    }

    public function scopeSearchEventType($q, $term)
    {
        $q->when(
            $term ?? false,
            fn($q, $term) => $q->where('event_type_id', $term)
        );
    }
    public function scopeSearchMonth($q, $term)
    {
        $q->when(
            $term ?? false,
            fn($q, $term) => $q->where('date', 'like', '%' . $term . '%')
        );
    }
    public function scopeFindSubmitter($q, $term)
    {
       $dept_name = User::whereId($term)->first()->department_name;
        $q->when(
            $term ?? false,
            fn($q, $term) => $q->where('submitter', $term)
            ->orWhere('assign_to', $term)->orWhere('assign_to', $term)
            ->orWhereHas('reportBy', function ($q) use ($dept_name) {
                    $q->where('department_name', 'like', '%' . $dept_name . '%');
                })
        );
    }
    public function scopeSearchEventSubType($q, $term)
    {
        $q->when(
            $term ?? false,
            fn($q, $term) => $q->where('sub_event_type_id', $term)
        );
    }
    public function scopeSearchId($q, $term)
    {
        $q->when(
            $term ?? false,
            fn($q, $term) => $q->where('id', $term)
        );
    }

    public function scopeSearch($q, $term)
    {
        $q->when(
            $term ?? false,
            fn($query, $term) =>
            $query->where('reference', 'LIKE', "%{$term}%")
                ->orWhere('description', 'LIKE', "%{$term}%")
                ->orWhereHas('eventType', function ($q) use ($term) {
                    $q->where('type_eventreport_name', 'like', '%' . $term . '%');
                })
                ->orWhereHas('subEventType', function ($q) use ($term) {
                    $q->where('event_sub_type_name', 'like', '%' . $term . '%');
                })

                ->orWhereHas('Site', function ($q) use ($term) {
                    $q->where('site_name', 'like', '%' . $term . '%');
                })
                ->orWhereHas('eventLocation', function ($q) use ($term) {
                    $q->where('location_event_name', 'like', '%' . $term . '%');
                })
                ->orWhereHas('WorkflowDetails', function ($q) use ($term) {
                    $q->whereHas('Status', function ($q) use ($term) {
                        $q->where('status_name', 'like', '%' . $term . '%');
                    });
                })

        );
    }
}
