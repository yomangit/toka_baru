<?php

namespace App\Imports;

use App\Models\ManhoursSite;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ManhoursSiteImport implements ToModel, WithHeadingRow, SkipsEmptyRows
{
    use Importable;
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new ManhoursSite([
            'date' => $row['date'],
            'Company_Employee' => $row['company_employee'],
            'Company_Workhours' => $row['company_workhours'],
            'Company_Cummulatives' => $row['company_cummulatives'],
            'Contractor_Employee' => $row['contractor_employee'],
            'Contractor_Workhours' => $row['contractor_workhours'],
            'Contractor_Cummulatives' => $row['contractor_cummulatives'],
            'Total_Employee' => $row['total_employee'],
            'Total_Workhours' => $row['total_workhours'],
            'Total_Cummulatives' => $row['total_cummulatives'],
            'Cummulatives_Manhours_By_LTI' => $row['cummulatives_manhours_by_lti'],
            'LTI' => $row['lti'],
            'LTI_Date' => $row['lti_date'],
        ]);
    }
    public function isEmptyWhen(array $row): bool
    {
        return $row['date'] === 0;
        return $row['company_employee'] === 0;
        return $row['company_workhours'] === 0;
        return $row['company_cummulatives'] === 0;
        return $row['contractor_employee'] === 0;
        return $row['contractor_workhours'] === 0;
        return $row['contractor_cummulatives'] === 0;
        return $row['total_employee'] === 0;
        return $row['total_workhours'] === 0;
        return $row['total_cummulatives'] === 0;
        return $row['cummulatives_manhours_by_lti'] === 0;
        return $row['lti'] === 0;
        return $row['lti_date'] === "-";
    }
}
