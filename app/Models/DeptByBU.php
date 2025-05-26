<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeptByBU extends Model
{
    use HasFactory;
    protected $table = 'dept_by_business_units';
    protected $fillable = [
        'busines_unit_id',
        'department_id',
    ];
    public function scopeSearchDept($query, $term)
    {
        $query->when(
            $term ?? false,
            fn ($query, $term) =>
            $query->whereHas('Department', function ($q) use ($term) {
                $q->where('department_name', 'like', '%' . $term . '%');
            })
        );
    }

    public function BusinesUnit()
    {
        return $this->belongsTo(BusinesUnit::class, 'busines_unit_id');
    }
    public function Department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function DeptByBU(){
        return $this->belongsToMany(DeptByBU::class, 'class_hierarchies');
    }

}
