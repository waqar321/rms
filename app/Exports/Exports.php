<?php

namespace App\Exports;

use App\Models\Admin\ecom_category;
use App\Models\Admin\ecom_course;
use App\Models\Admin\ecom_lecture;
use App\Models\Admin\ecom_department;
use App\Models\Admin\ecom_admin_user;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Facades\DB;

class Exports implements FromCollection, WithHeadings, WithMapping
{
    private $Modeldata;

    public function __construct($data) 
    {
        $this->Modeldata = $data;

        // dd(ecom_course::find(20)->category->name);
        // dd($this->Modeldata);
    }
    public function headings(): array
    {
        return $this->Modeldata['column'];
    }
    public function map($ModelIteration): array
    {
        foreach($this->Modeldata['column'] as $column)
        {
            // if($this->Modeldata['table'] == 'department')
            // {
            //     $departmentRow[] = UpdateDepartmentExportColumns($column, $ModelIteration);
            // }
            // else if($this->Modeldata['table'] == 'category')
            // {
            //     $departmentRow[] = UpdateCategoryExportColumns($column, $ModelIteration);
            // }
            // else if($this->Modeldata['table'] == 'admin_user')
            // {
            //     $departmentRow[] = UpdateUserExportColumns($column, $ModelIteration);
            // }
            $departmentRow[] = ExportValues($column, $ModelIteration, $this->Modeldata['table']);
        }

        return $departmentRow;
    }
    public function collection()
    {
        if($this->Modeldata['table'] == 'category')
        {
            return ecom_category::with('parentCategory')->find($this->Modeldata['IDs']);
        }   
        else if($this->Modeldata['table'] == 'department')
        {
            return ecom_department::with('parentDepartment')->find($this->Modeldata['IDs']);
        }
        if($this->Modeldata['table'] == 'admin_user')
        {
            return ecom_admin_user::find($this->Modeldata['IDs']);
        }
        if($this->Modeldata['table'] == 'course')
        {
            return ecom_course::find($this->Modeldata['IDs']);
        }
        if($this->Modeldata['table'] == 'lecture')
        {
            return ecom_lecture::find($this->Modeldata['IDs']);
        }

        // return DB::table($this->Modeldata['model'])->whereIn('id', $this->Modeldata['IDs'])->get();
    }
}
