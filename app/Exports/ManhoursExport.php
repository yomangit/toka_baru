<?php

namespace App\Exports;

use App\Models\Manhours;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
class ManhoursExport implements FromQuery, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use Exportable;
    protected $seleted_manhours =[];
   public function __construct($seleted_manhours)
   {
    $this->seleted_manhours = $seleted_manhours;
    
   }
   
     public function map( $manhours):Array
    {
      
        return[
            date('M-Y',strtotime($manhours->date)),
            $manhours->company_category,
            $manhours->company,
            $manhours->department,
            $manhours->dept_group,
            $manhours->job_class,
            $manhours->manhours,
            $manhours->manpower,
        ];
    }
    public function headings():array
    {
        return [
            'MONTH',
            'COMPANY CATEGORY',
            'COMPANY',
            'DEPARTMENT',
            'DEPT GROUP',
            'JOB CLASS',
            'MANHOURS',
            'MANPOWER',
        ];
    }
 public function query()
    {
        
       return Manhours::whereIn('id',$this->seleted_manhours);

    }
   
}
