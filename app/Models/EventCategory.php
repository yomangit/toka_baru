<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventCategory extends Model
{
    use HasFactory;
    protected $table='event_categories';
    protected $fillable = [
        'event_category_name',
    ];

    public function scopeSearchData($query,$term){
       
        $query->when(
            $term ?? false,
            fn ($query, $term) =>$query->where('event_category_name', 'LIKE', '%' . $term . '%'));
    }
}
