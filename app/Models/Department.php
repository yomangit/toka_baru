<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;
    protected $table = 'departments';
    protected $guarded = ['id'];
    public function scopeSearchDepartment($query, $term)
    {
        $query->when(
            $term ?? false,
            fn ($query, $term) =>$query->where('department_name', 'LIKE', '%' . $term . '%'));
    }
    public function Group()
    {
        return $this->belongsToMany(Group::class, 'dept_groups');
    }
    public function Company()
    {
        return $this->belongsToMany(Company::class, 'sub_con_depts');
    }
    public function BusinessUnit()
    {
        return $this->belongsToMany(BusinesUnit::class, 'dept_by_business_units');
    }
}
