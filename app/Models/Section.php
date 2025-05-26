<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Section extends Model
{
    use HasFactory;
    protected $table ='sections';
    protected $fillable = ['name'];

    public function scopeSearchName($query, $term){
        $query->when(
            $term?? false,
            fn ($query, $term) =>$query->where('name', 'LIKE', '%' . $term . '%'));
    }
}
