<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleUserPermit extends Model
{
    use HasFactory;
    protected $table = 'role_user_permits';
    protected $fillable = [
        'name_role_user'
    ];

}
