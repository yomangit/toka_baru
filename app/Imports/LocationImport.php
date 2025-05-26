<?php

namespace App\Imports;

use App\Models\LocationEvent;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
class LocationImport implements ToModel,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new LocationEvent([
           'location_name'=>$row['location_name'],
        ]);
    }
   
}
