<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    protected $table = 'companies';
    protected $fillable = [
        'name_company',
        'company_category_id',
    ];
    public function scopeSearchCompany($query, $term)
    {
        $query->when(
            $term ?? false,
            fn ($query, $term) => $query->where('name_company', 'LIKE', '%' . $term . '%')
        );
    }
    public function scopeSearchCompanyCategory($query, $term)
    {

        $query->when(
            $term ?? false,
            fn ($query, $term) =>
            $query->whereHas('CompanyCategory', function ($q) use ($term) {
                $q->where('name_category_company', 'like', '%' . $term . '%');
            })
        );
    }
    public function CompanyCategory()
    {
        return $this->belongsTo(CompanyCategory::class, 'company_category_id');
    }
    public function Department()
    {
        return $this->belongsToMany(Department::class, 'sub_con_depts');
    }
    public function BusinesUnit()
    {
        return $this->belongsToMany(DeptByBU::class, 'workgroups');
    }


   
}
