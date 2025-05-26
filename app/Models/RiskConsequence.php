<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiskConsequence extends Model
{
    use HasFactory;
    protected $table = 'risk_consequences';
    protected $fillable = [
        'risk_consequence_name',
        'description'
    ];
    public function scopeSearchRiskConsequence($query, $term) {
        $query->when(
            $term ?? false,
            fn ($query, $term) =>$query->where('risk_consequence_name', 'LIKE', '%'. $term. '%'));
    }
    public function RiskLikelihood()
    {
        return $this->belongsToMany(RiskLikelihood::class,'table_risk_assessments');
    }

    public function RiskAssessment()
    {
        return $this->belongsToMany(RiskAssessment::class,'table_risk_assessments');
    }
}
