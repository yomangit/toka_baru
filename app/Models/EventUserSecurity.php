<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventUserSecurity extends Model
{
    use HasFactory;
    protected $table = 'event_user_securities';
    protected $fillable = [
        'responsible_role_id',
        'company_category_id',
        'busines_unit_id',
        'dept_by_business_unit_id',
        'division_id',
        'user_id',
        'name',
        'type_event_report_id',
    ];
    public function Division()
    {
        return $this->belongsTo(Division::class);
    }

    public function ResponsibleRole()
    {
        return $this->belongsTo(ResponsibleRole::class);
    }

    public function Company()
    {
        return $this->belongsTo(CompanyCategory::class, 'company_category_id');
    }
    public function BusinesUnit()
    {
        return $this->belongsTo(BusinesUnit::class, 'busines_unit_id');
    }
    public function DeptByBU()
    {
        return $this->belongsTo(DeptByBU::class, 'dept_by_business_unit_id');
    }

    public function User()
    {
        return $this->belongsTo(User::class);
    }
    public function EventType()
    {
        return $this->belongsTo(TypeEventReport::class, 'type_event_report_id');
    }

    public function scopeSearchEventType($q, $t)
    {

        $q->when(
            $t ?? false,
            fn($q, $t) => $q->where('type_event_report_id', 'LIKE', $t)
        );
    }
    public function scopeSearchUserId($q, $t)
    {

        $q->when(
            $t ?? false,
            fn($q, $t) => $q->where('user_id', 'LIKE', $t)
        );
    }
    public function scopeSearchCompany($q, $t)
    {
        $q->when(
            $t ?? false,
            fn($q, $t) => $q->where('company_category_id', 'LIKE', $t)
        );
    }
    public function scopeSearchDept($q, $t)
    {
        $q->when(
            $t ?? false,
            fn($q, $t) => $q->where('dept_by_business_unit_id', 'LIKE', $t)
        );
    }
    public function scopeSearchDivision($q, $t)
    {
        $q->when(
            $t ?? false,
            fn($q, $t) => $q->where('division_id', 'LIKE', $t)
        );
    }
    
   
}
