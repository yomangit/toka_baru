<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiskLikelihood extends Model
{
    use HasFactory;
    protected $table = 'risk_likelihoods';
    protected $fillable = [
        'risk_likelihoods_name',
        'notes',
    ];
    public function scopeSearchRisk($query, $term)
    {
        $query->when(
            $term ?? false,
            fn ($query, $term) => $query->where('risk_likelihoods_name', 'LIKE', '%' . $term . '%')
        );
    }
    public function RiskConsequence()
    {
        return $this->belongsToMany(RiskConsequence::class,'table_risk_assessments');
    }
    public function RiskAssessment()
    {
        return $this->belongsToMany(RiskAssessment::class,'table_risk_assessments');
    }
}
