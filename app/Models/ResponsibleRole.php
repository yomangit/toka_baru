<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResponsibleRole extends Model
{
    use HasFactory;
    protected $table = 'responsible_roles';
    protected $fillable = [
        'responsible_role_name',
    ];
    public function User(){
        return $this->belongsToMany(User::class, 'event_user_securities');
    }
}
