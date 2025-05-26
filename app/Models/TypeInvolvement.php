<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeInvolvement extends Model
{
    use HasFactory;
    protected $table='type_involvements';
    protected $fillable =[
        'name'
    ];
    public function scopeSearch($query, $t)
    {
        $query->when(
            $t ?? false,
            fn($query, $t) => $query->where('name', 'LIKE', '%' . $t . '%')
        );
    }


    
}
