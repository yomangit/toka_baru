<?php

namespace App\Imports;

use App\Models\Manhours;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ManhoursImport implements ToModel,WithHeadingRow, SkipsEmptyRows
{
    use Importable;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Manhours([
            'date'=>$row['date'],
            'company_category'=>$row['company_category'],
            'company'=>$row['company'],
            'department'=>$row['department'],
            'dept_group'=>$row['dept_group'],
            'job_class'=>$row['job_class'],
            'manhours'=>$row['manhours'],
            'manpower'=>$row['manpower'],
        ]);
    }
    public function isEmptyWhen(array $row): bool
    {
        return $row['date'] === '-';
        return $row['company_category'] === '-';
        return $row['company'] === '-';
        return $row['department'] === '-';
        return $row['dept_group'] === '-';
        return $row['job_class'] === '-';
        return $row['manhours'] === '-';
        return $row['manpower'] === '-';
    }
    public function rules(): array
    {
        return [
            'date'=>'required|date_format:Y/m/d'
        ];
    }
}
