<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventParticipants extends Model
{
    use HasFactory;
    protected $table='event_participants';
    protected $fillable =[
        'type_involvement_id',
        'user_id',
        'type_event_report_id',
        'eventsubtype_id',
        'reference',
    ];
    public function scopeSearch($query, $term)
    {
        $query->when(
            $term ?? false,
            fn ($query, $term) =>$query->where('reference', 'LIKE', $term ));
    }
    public function User()
    {
        return $this->belongsTo(User::class);
    }
    public function TypeInvolvement()
    {
        return $this->belongsTo(TypeInvolvement::class);
    }
    public function subEventType(){
        return $this->belongsTo(Eventsubtype::class);
    }
    public function eventType(){
        return $this->belongsTo(TypeEventReport::class);
    }
    public function HazardReport(){
        return $this->belongsTo(HazardReport::class);
    }
    public function IncidentReport(){
        return $this->belongsTo(IncidentReport::class);
    }
}
