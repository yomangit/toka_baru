<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkflowDetail extends Model
{
    use HasFactory;
    protected $table = 'workflow_details';
    protected $fillable = [
        'name',
        'description',
        'status_event_id',
        'responsible_role_id',
        'destination_1',
        'destination_1_label',
        'destination_2',
        'destination_2_label',
        'is_cancel_step',
        'workflow_administration_id'
    ];
    public function scopeSearchTemplate($query,$term){
        return $query->where('workflow_administration_id','LIKE',$term);
    }
    public function Status(){
        return $this->belongsTo(StatusEvent::class,'status_event_id');
    }
    public function ResponsibleRole(){
        return $this->belongsTo(ResponsibleRole::class,'responsible_role_id');
    }
    public function WorkflowAdministration(){
        return $this->belongsTo(WorkflowAdministration::class,'workflow_administration_id');
    }

}
