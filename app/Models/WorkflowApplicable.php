<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkflowApplicable extends Model
{
    use HasFactory;
    protected $table = 'workflow_applicables';
    protected $fillable = [
        'type_event_report_id',
        'workflow_administration_id'
    ];
    public function scopeSearchTemplate($query,$term){
        return $query->where('workflow_administration_id','LIKE',$term);
    }
    public function EventType(){
        return $this->belongsTo(TypeEventReport::class,'type_event_report_id');
    }
    public function WorkflowAdministration(){
        return $this->belongsTo(WorkflowAdministration::class,'workflow_administration_id');
    }
}
