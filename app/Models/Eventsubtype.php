<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Eventsubtype extends Model
{
    use HasFactory;
    protected $table = 'eventsubtypes'; 
    protected $fillable = [
        'event_type_id',
        'event_sub_type_name',
    ];
    public function scopeSearchData($query,$term){

        return $query->where('event_sub_type_name','LIKE',"%{$term}%");
    }
    public function scopeSearchEventSubtipe($query,$term){
        $query->when(
            $term ?? false,
            fn ($query, $term) =>
                $query->where('event_type_id', 'like', $term)
        );
    }
    public function eventtype(){
        return $this->belongsTo(TypeEventReport::class,'event_type_id');  // one to many relationship with Eventtype model. 1 eventtype has many eventsubtypes. 1 to many relationship.
    }
}
