<?php

namespace App\Exports;

use App\Models\Admin\ecom_admin_user;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class EmployeeIDsExport implements FromCollection, WithHeadings, WithMapping
{
    private $headers;

    public function __construct($headers) 
    {
        $this->headers = $headers;   //EmployeeIDs, InstructorIDs, DepartmentIDs, SubDepartmentIDs, ZoneIDs, CityIDs, BranchIDs, BranchIDs, RoleIDs, ScheduleIDs
    }

    public function headings(): array
    {
        return $this->headers;
    }
    public function map($row): array
    {   
        return $row;
    }
    public function collection()
    {
        return collect([
            [83131, '831313', 2, 5, 2, '', 35, 29, 1],
            [83130, '831314', 4, 11, 3, '', 74, 31, ""],
            [83131, '831315', 5, 8, 6, 78, "", ""],
            [83132, '831316', 1, 9, 12, '', 82, "", ""],
        ]);
    }
}
