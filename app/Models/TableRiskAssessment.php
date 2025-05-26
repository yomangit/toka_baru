<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TableRiskAssessment extends Model
{
    use HasFactory;
    protected $table = 'table_risk_assessments';
    protected $fillable = [
        'risk_assessment_id',
        'risk_consequence_id',
        'risk_likelihood_id',
    ];

    public function scopeSearchLikelihood($query,$trim){
        return $query->where('risk_likelihood_id', 'LIKE', $trim);
    }
    public function scopeSearchConsequence($query,$trim){
        return $query->where('risk_consequence_id', 'LIKE', $trim);
    }

    public function RiskAssessment()
    {
        return $this->belongsTo(RiskAssessment::class);
    }
    public function RiskConsequence()
    {
        return $this->belongsTo(RiskConsequence::class);
    }
    public function RiskLikelihood()
    {
        return $this->belongsTo(RiskLikelihood::class);
    }
}
