<?php

namespace App\Jobs\Api;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use App\Models\Admin\ecom_department;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Support\Facades\DB;

class FetchDepartmentApiDataJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct()
    {      
        // DB::transaction(function () 
        // {
        //     DB::table('ecom_department')->delete();
        // });
    }
    public function handle()
    {
       
        $AllPArentDepartments = ecom_department::all();

        // $response = Http::get('http://172.16.0.13/HR/Api/getalldept.aspx');
        $response = Http::get('http://leopardsweb.com/HR/Api/getalldept.aspx');

        if ($response->successful()) 
        {
            
            $departments = $response->json();
            
            // -------- get all parent IDS uniquely,
            $DeptIds = [];
            foreach ($departments as $department)
            {
                if (!array_key_exists($department['DeptId'], $DeptIds)) {
                    $DeptIds[$department['DeptId']] = $department['DeptName'];
                }
            }
   
            // -------- insert all parent IDS uniquely,
            foreach ($DeptIds as $department_id => $department_name)
            {
                $ecom_department = ecom_department::updateOrCreate(
                    ['department_id' => $department_id],
                    ['name' => $department_name]
                );
            }

            // -------- get all Sub Department IDS uniquely,
            $SubDeptIds = [];
            foreach ($departments as $department) 
            {
                if (!array_key_exists($department['SubDeptId'], $SubDeptIds)) 
                {
                    $SubDeptIds[$department['SubDeptId']] = $department;
                }
            }
            
            // dd($SubDeptIds);
            // -------- insert all parent IDS uniquely,
            foreach ($SubDeptIds as $SubDepartment) 
            {
                $Parent = ecom_department::where('department_id', $SubDepartment['DeptId'])->first();

                ecom_department::updateOrCreate(
                    ['sub_department_id' => $SubDepartment['SubDeptId']],
                    [
                        'name' => $SubDepartment['SubDeptName'],
                        'parent_id' => $Parent->department_id,     //$SubDepartment['DeptId']
                    ]
                );
            }
            Log::info('Department data saved successfully');
        }
        else 
        {
            Log::error('Failed to fetch Department data');
        }
    }
}
