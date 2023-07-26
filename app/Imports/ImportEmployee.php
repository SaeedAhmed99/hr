<?php

namespace App\Imports;

use App\Models\Hrm;
use App\Models\User;
use App\Models\Branch;
use App\Models\Employee;
use App\Models\Department;
use App\Models\Designation;
use Illuminate\Support\Carbon;
use App\Models\BankInformation;
use Illuminate\Support\Collection;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;

class ImportEmployee implements ToCollection
{
    public function collection(Collection $rows)
    {
        $branch_all = Branch::all();
        $department_all = Department::all();
        $designation_all = Designation::all();

        //dd($rows);
        foreach ($rows as $key => $row) {
            if ($key > 0) {
                $user = User::create([
                    'name' => $row[0],
                    'email' => $row[1],
                    'password' => Hash::make($row[2]),
                    'lang' => 'en',
                    'status' => 1,
                ]);

                $role_r = Role::where('name', $row[3])->first();
                $user->assignRole($role_r->id);

                Hrm::create([
                    'user_id' => $user->id,
                    'type' => 'employee',
                    'active_status' => 1,
                ]);

                $branch = $branch_all->where('name', $row[9])->first();
                $department = $department_all->where('name', $row[10])->where('branch_id',$branch->id)->first();
                $designation = $designation_all->where('name', $row[11])->first();

                $employee = Employee::create([
                    'user_id' => $user->id,
                    'dob' => $row[4],
                    'gender' => $row[5],
                    'phone' => $row[6],
                    'address' => $row[7],
                    'employee_id' => $row[8],
                    'branch_id' => $branch->id,
                    'department_id' => $department->id,
                    'designation_id' => $designation->id,
                    'date_of_joining' => $row[12],
                    'salary_type' => $row[13],
                    'salary' => $row[14],
                ]);

                BankInformation::create([
                'employee_id' => $employee->id,
                'account_holder_name' => $row[15],
                'account_number' => $row[16],
                'bank_name' => $row[17],
                'bank_identifier_code' => $row[18],
                'bank_location' => $row[19],
                'tax_payer_id' => $row[20],
            ]);
            }
        }
    }
}
