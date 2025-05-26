<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActionIncident extends Model
{
    use HasFactory;
    protected $table = 'action_incidents';
    protected $fillable = [
        'incident_id',
        'followup_action',
        'actionee_comment',
        'action_condition',
        'responsibility',
        'due_date',
        'completion_date',
    ];
    public function Incident()
    {
        return $this->belongsTo(IncidentReport::class);
    }
    public function users()
    {
        return $this->belongsTo(User::class, 'responsibility');
    }
    public function scopeSearchIncident($query, $term)
    {
        $query->when(
            $term ?? false,
            fn($query, $term) =>
            $query->whereHas('Incident', function ($q) use ($term) {
                $q->where('task_being_done', 'like', '%' . $term . '%');
            })->orwhereHas('users', function ($q) use ($term) {
                $q->where('lookup_name', 'like', '%' . $term . '%');
            })
        );
    }
}
