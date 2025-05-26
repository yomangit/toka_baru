<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventKeyword extends Model
{
    protected $table ='event_keywords';
    protected $fillable =[
        'report_type',
        'keyword',
        'reference',
        'event_date'
       
    ];
}
