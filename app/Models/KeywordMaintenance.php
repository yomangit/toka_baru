<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KeywordMaintenance extends Model
{
    protected $table = 'keyword_maintenances';
    protected $fillable = [
        'name',
        'parent_id'
    ];

    public function children()
    {
        return $this->hasMany(KeywordMaintenance::class, 'parent_id')->with('children');
    }
}
