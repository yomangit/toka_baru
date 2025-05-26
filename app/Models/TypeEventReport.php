<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeEventReport extends Model
{
    use HasFactory;
    protected $table = 'type_event_reports';
    protected $fillable = [
        'event_category_id',
        'type_eventreport_name',
    ];

    public function scopeSearchEventType($query,$term){
        $query->when(
            $term ?? false,
            fn ($query, $term) => $query->where('type_eventreport_name', 'LIKE', '%' . $term . '%')
        );
    }
    public function scopeSearchEventCategory($query,$term){
        $query->when(
            $term ?? false,
            fn ($query, $term) =>
            $query->whereHas('EventCategory', function ($q) use ($term) {
                $q->where('event_category_name', 'like', '%' . $term . '%');
            })
        );
    }
    public function EventCategory()
    {
        return $this->belongsTo(EventCategory::class,'event_category_id');
    }
}
