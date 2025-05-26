<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncidentDocumentation extends Model
{
    use HasFactory;
    protected $table = 'doc_incident_reports';
    protected $fillable = [
        'name_doc',
        'incident_id',
        'description'
    ];
}
