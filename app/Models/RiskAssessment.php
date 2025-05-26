<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiskAssessment extends Model
{
    use HasFactory;
    protected $table = 'risk_assessments';
    protected $fillable = [
        'risk_assessments_name',
        'notes',
        'action_days',
        'coordinator',
        'reporting_obligation',
        'colour'
    ];
    public function scopeSearchRiskAssessment($query, $term){
        $query->when(
            $term?? false,
            fn ($query, $term) => $query->where('risk_assessments_name', 'LIKE', '%'. $term .'%'));
    }

    public function RiskLikelihood()
    {
        return $this->belongsToMany(RiskLikelihood::class,'table_risk_assessments');
    }

    public function RiskConsequence()
    {
        return $this->belongsToMany(RiskConsequence::class,'table_risk_assessments');
    }
}
