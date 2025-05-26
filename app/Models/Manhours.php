<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manhours extends Model
{
    use HasFactory;
    protected $table ='manhours'; 
    protected $fillable = [
        'date',
        'company_category',
        'company',
        'department',
        'dept_group',
        'job_class',
        'manhours',
        'manpower',
    ];
    public function scopeSearchManhours($query, $term){
        $query->when(
            $term ?? false,
            fn ($query, $term) =>
            $query->where('company_category', 'LIKE', '%' . $term . '%')
            ->orWhere('company', 'LIKE', '%' . $term . '%')
            ->orWhere('department', 'LIKE', '%' . $term . '%')
            ->orWhere('dept_group', 'LIKE', '%' . $term . '%')
            ->orWhere('job_class', 'LIKE', '%' . $term . '%')
            ->orWhere('date', 'LIKE', '%' . $term . '%')
        );
    }
    public function scopeSearchDate($query, $term){
        $query->when(
            $term ?? false,
            fn ($query, $term) =>
            $query->where('date', 'LIKE', "%$term%")
           
        );
    }
    public function scopeSearchCompanyCategory($query, $term){
        $query->when(
            $term ?? false,
            fn ($query, $term) =>
            $query->where('company_category', 'LIKE', "%$term%")
        );
    }
    public function scopeSearchCompany($query, $term){
        $query->when(
            $term ?? false,
            fn ($query, $term) =>
            $query->where('company', 'LIKE', "%$term%")
        );
    }
    public function scopeSearchDepartment($query, $term){
        $query->when(
            $term ?? false,
            fn ($query, $term) =>
            $query->where('department', 'LIKE', "$term")
        );
    }
    public function scopeSearchDeptGroup($query, $term){
        $query->when(
            $term ?? false,
            fn ($query, $term) =>
            $query->where('dept_group', 'LIKE', "$term")
        );
    }
   
}

