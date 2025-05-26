<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncidentReport extends Model
{

    use HasFactory;
    protected $table = 'incident_reports';
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
        'involved_eqipment',
        'preliminary_cause',
        'event_location_id',
        'immediate_action_taken',
        'key_learning',
        'risk_consequence_id',
        'risk_likelihood_id',
        'report_by_nolist',
        'report_to_nolist',
        'moderator',
        'status',
        'closed_by',
        'responsible_manager',
        'workflow_detail_id',
        'assign_to',
        'also_assign_to',
        'comments',
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
    public function Division()
    {
        return $this->belongsTo(Division::class, 'division_id');
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
    public function scopeStatusOpen($query, $term)
    {
        $query->when(
            $term ?? false,
            fn($query, $term) =>
            $query->whereHas('WorkflowDetails', function ($q) use ($term) {
                $q->whereHas('Status', function ($q) use ($term) {
                    $q->where('status_name', 'not like', '%' . $term . '%');
                });
            })
        );
    }
    public function scopeSearchDivision($q, $term)
    {
        $q->when(
            $term ?? false,
            fn($q, $t) => $q->whereHas('Division', function ($q) use ($t) {
                $q->whereHas('DeptByBU', function ($q) use ($t) {
                    $q->whereHas('Department', function ($q) use ($t) {
                        $q->where('department_name', 'LIKE', $t);
                    });
                });
            })
        );
    }
     public function scopeSearchDivisionCompany($q, $t)
    {
        $q->when(
            $t ?? false,
            fn($q, $t) => $q->whereHas('Division', function ($q) use ($t) {
                $q->whereHas('Company', function ($q) use ($t) {
                    $q->where('name_company', 'LIKE', '%' . $t . '%');
                });
            })
        );
    }
    public function scopeSearchDeptCom($q, $t)
    {
        
        $q->when(
            $t ?? false,
            fn($q, $t) => $q->whereHas('Division', function ($q) use ($t) {
                $q->whereHas('DeptByBU', function ($q) use ($t) {
                    $q->whereHas('Department', function ($q) use ($t) {
                        $q->where('department_name', 'LIKE', $t);
                    });
                })->orwhereHas('DeptByBU', function ($q) use ($t) {
                    $q->whereHas('BusinesUnit', function ($q) use ($t) {
                        $q->whereHas('Company', function ($q) use ($t) {
                           
                                $q->where('name_company', 'LIKE', '%' . $t . '%');
                            
                        });
                    });
                });
            })
        );
       
    }
    

    public function scopeSearchEventType($q, $t)
    {
        $q->when(
            $t ?? false,
            fn($q, $t) => $q->where('event_type_id', $t)
        );
    }
    public function scopeSearchTray($q, $t)
    {
        $q->when(
            $t ?? false,
            fn($q, $t) => $q->where('report_by', $t)
        );
    }
    public function scopeSearchUser($q, $t)
    {
        $q->when(
            $t ?? false,
            fn($q, $t) => $q->where('report_by','LIKE', $t)
            ->orWhere('report_to','LIKE', $t)
            ->orWhere('assign_to','LIKE', $t)
            ->orWhere('submitter','LIKE', $t)
            ->orWhere('also_assign_to','LIKE', $t)
        );
    }
    public function scopeSearchMonth($q, $term)
    {
        $q->when(
            $term ?? false,
            fn($q, $term) => $q->where('date', 'like', '%' . $term . '%')
        );
    }
    public function scopeSearchEventSubType($q, $term)
    {
        $q->when(
            $term ?? false,
            fn($q, $term) => $q->where('sub_event_type_id', $term)
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
                    $q->where('location_name', 'like', '%' . $term . '%');
                })->orWhereHas('WorkflowDetails', function ($q) use ($term) {
                $q->whereHas('Status', function ($q) use ($term) {
                    $q->where('status_name', 'like', '%' . $term . '%');
                });
            })
        );
    }
}
