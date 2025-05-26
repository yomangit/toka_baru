<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;
    protected $table = 'groups';
    protected $guarded = ['id'];
    public function scopeSearchGroup($query, $term)
    {

        $query->when(
            $term ?? false,
            fn ($query, $term) => $query->where('group_name', 'LIKE', '%' . $term . '%')
        );
    }
    public function scopeSearchDept($query, $term)
    {
        $query->when(
            $term ?? false,
            fn ($query, $term) =>
            $query->whereHas('Dept', function ($q) use ($term) {
                $q->where('department_name', 'like', '%' . $term . '%');
            })
        );
    }
    public function Dept()
    {
        return $this->belongsToMany(Department::class, 'dept_groups');
    }
}
