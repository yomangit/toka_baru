<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManhoursSite extends Model
{
    use HasFactory;
    protected $table ='manhours_sites';
    protected $fillable = [
       'date',
      'Company_Employee',
      'Company_Workhours',
      'Company_Cummulatives',
      'Contractor_Employee',
      'Contractor_Workhours',
      'Contractor_Cummulatives',
      'Total_Employee',
      'Total_Workhours',
      'Total_Cummulatives',
      'Cummulatives_Manhours_By_LTI',
      'Manhours_Lost',
      'LTI',
      'LTI_Date',
    ];

    public function scopeSearchDate($query, $term){
      $query->when(
          $term ?? false,
          fn ($query, $term) =>
          $query->where('date', 'LIKE', "%$term%")
         
      );
  }
}
