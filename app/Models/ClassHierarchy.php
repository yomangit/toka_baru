<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassHierarchy extends Model
{
    use HasFactory;
    protected $table = "class_hierarchies";
    protected $fillable = [
        'company_category_id',
        'busines_unit_id',
        'dept_by_business_unit_id',
        'division_id'
    ];
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
    public function Division()
    {
        return $this->belongsTo(Division::class, 'division_id');
    }

    public function scopeSearchParent($q, $t)
    {
        $q->when(
            $t ?? false,
            fn($q, $t) => $q->where('company_category_id', 'LIKE',  $t)
        );
    }
    public function scopeSearchDivision($q, $t)
    {
        $q->when(
            $t ?? false,
            fn($q, $t) => $q->where('division_id', 'LIKE', $t )
        );
    }
    public function scopeSearchBU($q, $t)
    {
        $q->when(
            $t ?? false,
            fn($q, $t) => $q->where('busines_unit_id', 'LIKE', $t )
        );
    }
    public function scopeSearchDept($q, $t)
    {
        $q->when(
            $t ?? false,
            fn($q, $t) => $q->where('dept_by_business_unit_id', 'LIKE', $t)
        );
    }
   
}
