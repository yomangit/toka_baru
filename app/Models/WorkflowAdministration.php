<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkflowAdministration extends Model
{
    use HasFactory;
    protected $table = 'workflow_administrations';
    protected $fillable = [
        'workflow_template_name',
    ];
}
