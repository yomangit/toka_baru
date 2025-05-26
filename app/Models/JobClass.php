<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobClass extends Model
{
    use HasFactory;
    protected $table = 'job_classes';
    protected $fillable = [
        'job_class_name',
    ];
    public function scopeSearchFor($query, $term)
    {
        $query->when(
            $term ?? false,
            fn ($query, $term) =>$query->where('job_class_name', 'LIKE', '%' . $term . '%'));
    }
    public function BusinesUnit()
    {
        return $this->belongsToMany(DeptByBU::class, 'workgroups');
    }
}
