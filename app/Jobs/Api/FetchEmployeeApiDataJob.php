<?php

namespace App\Jobs\Api;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use App\Models\Admin\ecom_admin_user;
use App\Models\Admin\ecom_department;
use App\Models\Admin\Zone;
use App\Models\Admin\central_ops_city;
use App\Models\Admin\ecom_employee_time_slots;

use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class FetchEmployeeApiDataJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 600; // (600 seconds = 10 minutes)

    public function __construct()
    {
        
    }  
    public function retryAfter()
    {
        return 60; // 15 minutes
    } 

    public function handle()
    {

        // ========================== Data Added To Chunks ==================================

            try 
            {
                // $response = Http::timeout(300)->get('http://172.16.0.13/HR/Api/getemployeelist.aspx');
                $response = Http::timeout(300)->get('http://leopardsweb.com/HR/Api/getemployeelist.aspx');
            }
            catch (\Exception $e) 
            {
                Log::error('Failed to fetch employees data: ' . $e->getMessage());
                return;
            }

            // Check if the response is successful
            if ($response->successful()) 
            {
                // Decode the JSON response into an array
                // $count =0;
                $employees = $response->json();
                
                // dd($employees[0]);

                $batchSize = 500;
                $totalCount = count($employees);
                Log::info('total employees '.$totalCount);   // primt total employees 9510
                $batches = array_chunk($employees, $batchSize);
                $ChunkQuantity = 0;
             
                foreach ($batches as $batch) 
                {
                    DB::beginTransaction();

                    try 
                    {
                        foreach ($batch as $chunk => $employee) 
                        {

                            // -----------------------verify city exists ----------------------

                                if(!central_ops_city::where('city_id', $employee['CityId'])->exists()) 
                                {
                                    $cityId = null;
                                    Log::error('Invalid city_id: ' . $cityId . ' for employee_id: ' . $employee['EMP_NO']);
                                    continue; 
                                }
                                else
                                {
                                    $cityId = $employee['CityId'];
                                }

                            // -----------------------verify zone exists ----------------------

                                if(!Zone::where('zone_code', $employee['ZoneId'])->exists()) 
                                {
                                    $zoneId = null;
                                    Log::error('Invalid zone_id: ' . $zoneId . ' for employee_id: ' . $employee['EMP_NO']);
                                    continue; 
                                }
                                else
                                {
                                    $zoneId = $employee['ZoneId'];
                                }


                            // -----------------------verify slot exists ----------------------
                                if (!ecom_employee_time_slots::where('shift_code', $employee['ShiftCode'])->exists())
                                {
                                    $timeSlotId = null;
                                    Log::error('Invalid time_slot_id: ' . $timeSlotId . ' for employee_id: ' . $employee['EMP_NO']);
                                    continue; 
                                }
                                else
                                {
                                    $timeSlotId = $employee['ShiftCode'];
                                }

                            // -----------------------verify department exists  ----------------------                  
                                if (!ecom_department::where('department_id', $employee['DeptId'])->exists())
                                {
                                    $departmentId= null;
                                    Log::error('Invalid department_id: ' . $departmentId . ' for employee_id: ' . $employee['EMP_NO']);
                                    continue; 
                                }
                                else
                                {
                                    $departmentId = $employee['DeptId'];
                                }
                                
                            // -----------------------verify sub department exists  ----------------------                                      
                                if (!ecom_department::where('sub_department_id', $employee['SubDeptId'])->exists())
                                {
                                    $sub_departmentId= null;
                                    Log::error('Invalid sub_department_id: ' . $departmentId . ' for employee_id: ' . $employee['EMP_NO']);
                                    continue; 
                                }
                                else
                                {
                                    $sub_departmentId = $employee['SubDeptId'];
                                }
                            // ---------------------------------------------  


                            try   // create or update employee
                            {
                                    
                                // dd($cityId, $zoneId, $timeSlotId, $departmentId, $sub_departmentId, $employee['EMP_NO'], $employee['NAME'], $employee['Designation'], $employee['ContactNumber'] );

                                $ecom_admin_user = ecom_admin_user::updateOrCreate(
                                    ['employee_id' => $employee['EMP_NO']], // Where clause
                                    [
                                        'employee_id' => $employee['EMP_NO'],
                                        'email' => $employee['Email'],
                                        // 'username' => $employee['EMP_NO'],
                                        'full_name' => $employee['NAME'],
                                        'designation' => $employee['Designation'],
                                        'phone' => $employee['ContactNumber'],
                                        'city_id' => $cityId,
                                        'zone_id' => $zoneId,
                                        'department_id' => $departmentId,
                                        'sub_department_id' => $sub_departmentId,
                                        'time_slot_id' => $timeSlotId,
                                        'role_id' => 34,
                                    ]
                                );
                                
                                $ecom_admin_user->save();

                                $exists = DB::table('role_user')
                                    ->where('user_id', $ecom_admin_user->id)
                                    ->where('role_id', 5)
                                    ->exists();

                                if (!$exists) 
                                {
                                    DB::table('role_user')->insert([
                                        'role_id' => 5,
                                        'user_id' => $ecom_admin_user->id,
                                    ]);
                                }


                            }
                            catch (\Exception $e) 
                            {
                                // Log::error('Failed to save employee data for: '. $employee->employee_id . $e->getMessage());
                                Log::error('Failed to save employee data for: '. $employee['EMP_NO'] . $e->getMessage());
                                continue; // Skip to the next employee in case of an error
                            }

                        }
                        DB::commit();
                        $ChunkQuantity = ($ChunkQuantity + $chunk);
                        Log::info(($ChunkQuantity+1) .' processed successfully');
                    } 
                    catch (\Exception $e) 
                    {
                        DB::rollBack();
                        Log::error('Failed to process batch: ' . $e->getMessage());
                    }

                    // break;
                }
            } 
            else 
            {
                Log::error('Failed to fetch employees data: API response unsuccessful');
            }

        // ========================== Data Added To Chunks ==================================
      
    }
}
