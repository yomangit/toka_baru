<?php
    
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusEvent extends Model
{
    use HasFactory;
    protected $table = 'status_events';
    protected $fillable = [
        'status_name',
        'bg_status'
    ];
    public function scopeSearchStatus($query, $term){
        $query->when(
            $term ?? false,
            fn ($query, $term) =>$query->where('status_name', 'LIKE', '%'. $term .'%'));
    }
}
