<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class route_request extends Model
{
    //
    use HasFactory;
    protected $table = 'route_requests';
    protected $fillable = [
        'route_name',
        'workflow_template_id'
    ];
    public function WorkflowAdministration(){
        return $this->belongsTo(WorkflowAdministration::class,'workflow_template_id');
    }
}
