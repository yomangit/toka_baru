<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class choseEventType extends Model
{
    protected $table = 'chose_event_types';
    protected $fillable = [
        'route_name',
        'event_type_id',
    ];
    public function eventType()
    {
        return $this->belongsTo(TypeEventReport::class, 'event_type_id');
    }
}
