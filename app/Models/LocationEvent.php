<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LocationEvent extends Model
{
    use HasFactory;
    protected $table = 'location_events';
    protected $fillable = [
        'location_name',
    ];
public function scopeSearchFor($query, $term){
    $query->when(
        $term?? false,
        fn ($query, $term) => $query->where('location_name', 'LIKE', '%'. $term .'%'));
}

    
}
