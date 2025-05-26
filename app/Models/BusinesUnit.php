<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinesUnit extends Model
{
    use HasFactory;
    protected $table = 'busines_units';
    protected $fillable = [
        'name_company_id',
    ];
    public function scopeSearch($query, $term)
    {
        $query->when(
            $term ?? false,
            fn ($query, $term) =>
            $query->whereHas('Company', function ($q) use ($term) {
                $q->where('name_company', 'like', '%' . $term . '%');
            })
        );
    }
    public function Company()
    {
        return $this->belongsTo(Company::class, 'name_company_id');
    }
    public function Department()
    {
        return $this->belongsToMany(Department::class, 'dept_by_business_units');
    }
    public function BusinesUnit(){
        return $this->belongsToMany(BusinesUnit::class, 'class_hierarchies');
    }
}
