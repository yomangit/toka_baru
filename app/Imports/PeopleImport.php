<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class PeopleImport implements ToModel,SkipsEmptyRows, WithHeadingRow, WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

   use SkipsErrors;
   public function rules(): array
    {
        return [
            'name' => ['nullable'],
            'password ' => ['nullable'],
            'email' => ['nullable'],
            'first_name' => ['nullable'],
            'last_name' => ['nullable'],
            'lookup_name' => ['nullable'],
            'employee_id' => ['nullable'],
            'date_birth' => ['nullable'],
            'date_commenced' => ['nullable'],
            'gender' => ['nullable'],
            'username' => ['nullable'],
            'company_id' => ['nullable'],
            'role_user_permit_id' => ['nullable'],
        ];
    }
    public function model(array $row)
    {
 
        return new User([
            'lookup_name'=>$row['lookup_name'],
            'date_birth'=>$row['date_birth'],
            'date_commenced'=>$row['date_commenced'],
            'company_id'=>$row['company_id'],
            'username'=>$row['username'],
            'employee_id'=>$row['employee_id'],
            'first_name'=>$row['first_name'],
            'last_name'=>$row['last_name'],
            'email'=>$row['email'],
            'gender'=>$row['gender'],
            'role_user_permit_id'=>2

        ]);
    }
}
