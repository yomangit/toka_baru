<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeptGroup extends Model
{
    use HasFactory;
    protected $table = 'dept_groups';
    protected $fillable = [
        'group_id',
        'department_id',
    ];
    public function scopeSearchGroup($query, $term)
    {

        $query->whereHas('Group', function ($q) use ($term) {
            $q->where('group_name', 'like', '%' . $term . '%');
        });
    }
    public function scopeSearchDept($query, $term)
    {

        $query->whereHas('Dept', function ($q) use ($term) {
            $q->where('department_name', 'like', '%' . $term . '%');
        });
    }
    public function scopeSearchGroupID($query, $term)
    {

        $query->when(
            $term?? false,
            fn ($query, $term) =>$query->where('group_id', 'LIKE', $term ));
    }
    public function scopeSearchDeptID($query, $term)
    {

        $query->when(
            $term?? false,
            fn ($query, $term) =>$query->where('department_id', 'LIKE',$term ));
    }
    public function Group()
    {
        return $this->belongsTo(Group::class);
    }
    public function Dept()
    {
        return $this->belongsTo(Department::class,'department_id');
    }

}
