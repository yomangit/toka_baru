<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserInputManhours extends Model
{
    protected $table = 'user_input_manhours';
    protected $fillable = [
        'user_id',
        'company_id'
    ];
    public function User()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function Company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
}
