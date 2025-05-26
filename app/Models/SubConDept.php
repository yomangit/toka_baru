<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubConDept extends Model
{
    use HasFactory;
    protected $table = 'sub_con_depts';
    protected $fillable = [
        'company_id',
        'department_id',
    ];

    public function Company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
    public function Dept()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
}
