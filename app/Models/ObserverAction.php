<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cjmellor\Approval\Concerns\MustBeApproved;

class ObserverAction extends Model
{
    use MustBeApproved;
    protected $table="observer_actions";
    protected $fillable = [
        'action',
        'by_who',
        'due_date',
        'completion_date',
        'reference'
    ];

    public function users(){
        return $this->belongsTo(User::class,'by_who');
    }
}
