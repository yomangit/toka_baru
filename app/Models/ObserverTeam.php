<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cjmellor\Approval\Concerns\MustBeApproved;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ObserverTeam extends Model
{
    use HasFactory;
    use MustBeApproved;
    protected $table ='observer_teams';
    protected $fillable = [
       'name',
      'id_card',
      'job_title',
      'reference',
    ];
    
}
