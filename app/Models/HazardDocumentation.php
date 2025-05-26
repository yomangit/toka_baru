<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HazardDocumentation extends Model
{
    use HasFactory;
    protected $table = 'hazard_documentations';
    protected $fillable = [
        'name_doc',
        'hazard_id',
        'description'
    ];

    public function scopeSearchHzdID($query, $term)
    {
        $query->when(
            $term ?? false,
            fn ($query, $term) =>$query->where('hazard_id', 'LIKE', $term ));
    }
}
