<?php 


namespace App\Traits\livewireComponentTraits;
use App\Models\Admin\ecom_course;
use App\Models\Admin\ecom_course_assign;
use App\Models\Admin\ecom_category;
use App\Models\Admin\ecom_department;
use App\Models\Admin\ecom_admin_user;
use App\Models\Admin\central_ops_city;
use App\Exports\EmployeeIDsExport;
use Illuminate\Http\UploadedFile;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use App\Traits\livewireComponentTraits\LivewireComponentsCommon;
use App\Rules\EitherOrRule;
use League\Csv\Reader;
use App\Traits\livewireComponentTraits\EventListeners\CourseAssignEventListeners;

trait CourseAssignCSVComponent
{
    use CourseAssignEventListeners;

    public function ValidateOrGetCSVData($Creating=false)
    {
        $this->resetErrorBag();
        

        if($this->update && !$this->csv_file)
        {
            //========= testing =============

                // Get the file path from the database
                $filePath = $this->ecom_course_assign->upload_csv;
                $fullfilePath = asset('Storage/'.$filePath);                
                $originalName = pathinfo($fullfilePath, PATHINFO_FILENAME);
                $fileExtension = pathinfo($fullfilePath, PATHINFO_EXTENSION);
                $file = new UploadedFile('Storage/'.$filePath, $originalName, null, null, true); // Create a new UploadedFile 

            //========= testing =============
        }
        else if($this->csv_file)
        {

            $file = $this->csv_file;
            $fileExtension = pathinfo($this->csv_file->getClientOriginalName(), PATHINFO_EXTENSION);

            if($fileExtension !== 'csv')
            {
                $this->Collapse = "uncollapse";
                $this->addError('csv_file', 'Invalid file format. Please upload a CSV file.');
                return false;
            }
        }
        
        $reader = Excel::toCollection(function ($reader) {
            $reader->ignoreEmpty();
            $reader->limitColumns(1);
        }, $file->getRealPath());
        
        $headers = $reader->first()->first();
        $Verify = $reader->first()->first()->toArray();
        
        
        if ($headers->count() == 9 && $Verify == array_keys($this->ExpectedCSVHeaders)) 
        {
            $data = $reader->first()->slice(1);
            

            $data->each(function ($row) use ($headers, &$columnValues) 
            {
                

                $row->each(function ($value, $index) use ($headers, &$columnValues) 
                {
                    $header = $headers[$index];                            
                    $columnValues[$header][] = $value;
                });
            });



            $headerContainNonInt = [];
            $headerContainNullValues = [];
            $headerContainNonStringValues = [];
            $headerContainValidIDs = [];
            
            foreach ($columnValues as $key => $columnvalue) 
            {
                $NullValuesExists = array_filter($columnvalue, function($value) {
                                return $value != null;
                            });

                if(empty($NullValuesExists))
                {
                    $headerContainNullValues[] = $key;
                    unset($columnValues[$key]);
                }
            }
          

            foreach($columnValues as $header => $columnvalue)
            {
                $containsNonInt = false;
                $containsNonStringForZone = false;
                
                foreach ($columnvalue as $value) 
                {
                    if($value != null)
                    {
                        if($header != 'ZoneIDs')
                        {
                            if (!is_int($value)) 
                            {
                                $containsNonInt = true;
                                break; 
                            }
                        }
                        else
                        {
                            if (!is_string($value))  
                            {
                                $containsNonStringForZone = true;
                                break; 
                            } 
                        }
                    }
                    // else
                    // {
                    //     $containsNullValues = true;
                    //     break;
                    // }
                }

                if ($containsNonInt) 
                {
                    $headerContainNonInt[] = $header;
                }
                else if($containsNonStringForZone)
                {
                    $headerContainNonStringValues[] = $header;
                }
                else
                {
                    $headerContainValidIDs[] = $header;
                }
            }
            
            if($Creating)
            {

                return [
                    'columnValues' => $columnValues,
                    'headerContainValidIDs' => $headerContainValidIDs,
                ];
            }

            $NonIntegersColumValues = implode(', ', $headerContainNonInt);
            $NullColumnValues = implode(', ', $headerContainNullValues);
            $ItShouldBeString = implode(', ', $headerContainNonStringValues);
            $ValidColumnValues = implode(', ', $headerContainValidIDs);

            if($NonIntegersColumValues != '')
            {
                $this->Collapse = "uncollapse";
                $this->addError('csv_file', 'Non Integer IDs Found in CSV For Columns: ' . ' ( ' . $NonIntegersColumValues . ' )  , Please Provide Valid Integer IDs e.g: 5, 254, 5000');
            }
            if($ItShouldBeString != '')
            {
                $this->Collapse = "uncollapse";
                $this->addError('csv_file', 'Integer ID Found in CSV For Columns: ' . ' ( ' . $ItShouldBeString . ' ) , Please Provide Zone Name e.g: ISB, HYD, FSD');
            }
            if($NullColumnValues != '')
            {
                $this->Collapse = "uncollapse";
                $this->addError('csv_file', 'No Record Found in CSV For Columns: ' . ' ( ' . $NullColumnValues . ' ) ');
            }
            if($ValidColumnValues != '')
            {
                $this->Collapse = "uncollapse";
                $this->addError('csv_file', 'Accepted Columns: Valid IDs Found in CSV For Columns : ' . ' ( ' . $ValidColumnValues . ' ) , Course will only be aligned to these sources');
            }          
        } 
        else
        {
            $this->Collapse = "uncollapse";
            $this->addError('csv_file', 'The CSV file must follow sample CSV Format for column names..!!');
        }        
       
    }
    public function GetExpectedCSVHeaderData($Notification =false)
    {

        
        // if($Notification)
        // {
        //     return [
        //         'EmployeeIDs' => [$this->ecom_notification->employee_id, 'employee_id'],
        //         'InstructorIDs' => [$this->ecom_notification->instructor_id, 'instructor_id'],
        //         'DepartmentIDs' => [$this->ecom_notification->department_id, 'department_id'],
        //         'SubDepartmentIDs' => [$this->ecom_notification->sub_department_id, 'sub_department_id'],
        //         'ZoneIDs' => [$this->ecom_notification->zone_name, 'zone_name'],
        //         'CityIDs' => [$this->ecom_notification->city_id, 'city_id'],
        //         'BranchIDs' => [$this->ecom_notification->branch_id, 'branch_id'],
        //         'RoleIDs' => [$this->ecom_notification->role_id, 'role_id'],
        //         'ScheduleIDs' => [$this->ecom_notification->shift_time_id, 'shift_time_id'],
        //     ]; 
        // }
        // else
        // {
        //     return [
        //         'EmployeeIDs' => [$this->ecom_course_assign->employee_id, 'employee_id'],
        //         'InstructorIDs' => [$this->ecom_course_assign->instructor_id, 'instructor_id'],
        //         'DepartmentIDs' => [$this->ecom_course_assign->department_id, 'department_id'],
        //         'SubDepartmentIDs' => [$this->ecom_course_assign->sub_department_id, 'sub_department_id'],
        //         'ZoneIDs' => [$this->ecom_course_assign->zone_name, 'zone_name'],
        //         'CityIDs' => [$this->ecom_course_assign->city_id, 'city_id'],
        //         'BranchIDs' => [$this->ecom_course_assign->branch_id, 'branch_id'],
        //         'RoleIDs' => [$this->ecom_course_assign->role_id, 'role_id'],
        //         'ScheduleIDs' => [$this->ecom_course_assign->shift_time_id, 'shift_time_id'],
        //     ]; 
        // }

        $source = $Notification ? $this->ecom_notification : $this->ecom_course_assign;

        return [
            'EmployeeIDs' => [$source->employee_id, 'employee_id'],
            'InstructorIDs' => [$source->instructor_id, 'instructor_id'],
            'DepartmentIDs' => [$source->department_id, 'department_id'],
            'SubDepartmentIDs' => [$source->sub_department_id, 'sub_department_id'],
            'ZoneCode' => [$source->zone_name, 'zone_name'],
            'CityIDs' => [$source->city_id, 'city_id'],
            'BranchIDs' => [$source->branch_id, 'branch_id'],
            'RoleIDs' => [$source->role_id, 'role_id'],
            'ScheduleIDs' => [$source->shift_time_id, 'shift_time_id'],
        ];
        
    }
    public function GetValidColumnsDataToStore()
    {
        $ValidHeaders = [];
        $CSVData = $this->ValidateOrGetCSVData(true);

        foreach($CSVData['headerContainValidIDs'] as $key => $Validheader)
        {
            if(array_key_exists('EmployeeIDs', $CSVData['columnValues']))
            {
                $ValidHeaders[$Validheader] = $CSVData['columnValues'][$Validheader];
            }
        }

        return $ValidHeaders;
    }
    public function RemoveAlreadyIDsInCSV()
    {

        foreach ($this->GetExpectedCSVHeaderData() as $key => $value) 
        {  
            if ($value != null && array_key_exists($key, $this->GetValidColumnsDataToStore())) 
            {
                if (in_array($value[0], $this->GetValidColumnsDataToStore()[$key])) 
                {
                    $this->ecom_course_assign->{$value[1]} = null;
                }
            }
        }

        return $this->GetValidColumnsDataToStore();
    }
    public function AtleastOneResourceToBeSelected()
    {

        if ($this->ecom_course_assign->instructor_id == '' &&
            $this->ecom_course_assign->employee_id == '' &&
            $this->ecom_course_assign->department_id == '' &&
            $this->ecom_course_assign->sub_department_id == '' &&
            $this->ecom_course_assign->zone_name == '' &&
            $this->ecom_course_assign->branch_id == '' &&
            $this->ecom_course_assign->role_id == '' &&
            $this->ecom_course_assign->shift_time_id == '' &&
            $this->ecom_course_assign->city_id == '' &&
            !$this->csv_file
        ) 
        {
            return true;
        } 
        else 
        {
            return false;
        }
    }

}