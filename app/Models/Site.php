<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    use HasFactory;
    protected $table ='sites';
    protected $fillable = ['site_name'];

    public function scopeSearchSite($query, $term){
        $query->when(
            $term?? false,
            fn ($query, $term) =>$query->where('site_name', 'LIKE', '%' . $term . '%'));
    }
}
