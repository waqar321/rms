<?php

use App\Models\Admin\ecom_course;
use App\Models\Admin\ecom_category;
use App\Models\Admin\ecom_admin_user;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Artisan;
use Carbon\Carbon;

function CleanCacheAndTempFiles()
{


    $oldFiles = Storage::files('livewire-tmp');
    
    foreach($oldFiles as $file)
    {
        Storage::delete($file);
    }
    // Clear cache
    Artisan::call('cache:clear');

    // Clear compiled views
    Artisan::call('view:clear');

    // Clear route cache
    Artisan::call('route:clear');

    // Clear configuration cache
    Artisan::call('config:clear');

    // Clear compiled views (again)
    Artisan::call('view:clear');

    // Clear optimized class loader
    Artisan::call('optimize:clear');
}
function deleteFile($path)
{
    if (file_exists(public_path('storage/') . $path)) 
    {
        // dd(public_path('storage/') . $path);

        unlink(public_path('storage/') . $path); 
    }
}
function storeFile($path, $file)
{
    // Store the file in the specified path
    $filename = $file->store($path, 'public');
    // Extract the filename without the path
    $filenameOnly = basename($filename);
    // Set the storage type and file path in your model
    return $path . '/' . $filenameOnly;
}
function ScanTempDirectory()
{
    $directory = storage_path('app/livewire-tmp');

    if (is_dir($directory) && !empty(array_diff(scandir($directory), ['.', '..']))) {
        return true;
    } else {
        return false;
    }


    // $directory = storage_path('app/livewire-tmp');
    // if (is_dir($directory)) 
    // {
    //     $files = array_diff(scandir($directory), ['.', '..']);
        
    //     if (count($files) > 0) 
    //     {
    //         return true;
    //     }
    //     else
    //     {
    //         return false;
    //     }
    // }
    // else
    // {
    //     return false;
    // }
}
function UpdateDepartmentExportColumns($column, $department)
{

    if($column == 'ID')
    {
       return $department->id;
    }
    else if($column == 'Department')
    {
       return $department->name;
    }
    else if($column == 'Parent Department')
    {
       return $department->parentDepartment->name;
    }
    else if($column == 'Date Created')
    {
        if ($department->created_at) 
        {
            $date = Carbon::createFromFormat('Y-m-d H:i:s', $department->created_at);
            return $date->format('d-m-Y');
        }
        else
        {
           return 'N/A';
        }
    }
    else if($column == 'Status')
    {
       return $department->is_active ? "Active" : "Not Active";
    }

}
function UpdateUserExportColumns($column, $ecom_admin_user)
{
   
    // $this->availableColumns = ['Employee Code', 'Name', 'Email', 'City', 'Roles', 'Designation', 'Date', 'Status', 'Action'];

    if($column == 'Employee Code')
    {
       return $ecom_admin_user->employee_id;
    }
    else if($column == 'Name')
    {
       return $ecom_admin_user->full_name;
    }
    else if($column == 'Email')
    {
       return $ecom_admin_user->email;
    }
    else if($column == 'City')
    {
       return $ecom_admin_user->city->city_name;
    }
    else if($column == 'Roles')
    {
        // return $ecom_admin_user->roles->pluck('title');
        return $ecom_admin_user->roles->pluck('title')->implode(', ');

    }

    else if($column == 'Designation')
    {
       return $ecom_admin_user->designation;
    }
    else if($column == 'Date Created')
    {
        if ($ecom_admin_user->created_at) 
        {
            $date = Carbon::createFromFormat('Y-m-d H:i:s', $ecom_admin_user->created_at);
            return $date->format('d-m-Y');
        }
        else
        {
           return 'N/A';
        }
    }
    else if($column == 'Status')
    {
       return $category->is_active ? "Active" : "Not Active";
    }

}
function UpdateCategoryExportColumns($column, $category)
{
   
    if($column == 'ID')
    {
       return $category->id;
    }
    else if($column == 'Category')
    {
       return $category->name;
    }
    else if($column == 'Parent Category')
    {
       return $category->parentCategory->name;
    }
    else if($column == 'Date Created')
    {
        if ($category->created_at) 
        {
            $date = Carbon::createFromFormat('Y-m-d H:i:s', $category->created_at);
            return $date->format('d-m-Y');
        }
        else
        {
           return 'N/A';
        }
    }
    else if($column == 'Status')
    {
       return $category->is_active ? "Active" : "Not Active";
    }

}
function ReplaceStringAttributeValuesWithNull($Model)
{
    $attributes = $Model->toArray();

    $attributes = array_filter($attributes,  function($attribute){
        return $attribute === '';
    });

    if (!empty($attributes)) 
    {
        array_walk($attributes, function (&$value) {
            $value = null;
        });

        foreach($attributes as $attribute => $attributeValue)
        {
            $Model->{$attribute} = $attributeValue;
        }
    }
    return $Model;
}
function Permission($permission_id)
{
    if(auth()->user()->role->id == 1)
    {

        return true;
    }
    else 
    {
        // dd(auth()->user()->role->ecom_module_permissions->pluck('sub_module_id'));
        $permission_Ids = auth()->user()->role->ecom_module_permissions->pluck('screen_permission_id')->toArray();
        // dd($permission_Ids);
        return in_array($permission_id , $permission_Ids);
    }
}
function getTimeDifference($dateTime)
{
    // Parse the provided datetime string into a Carbon instance
    $createdAt = Carbon::parse($dateTime);
    return $createdAt->diffForHumans();
    
    // Calculate the difference in seconds
    $difference = $createdAt->diffInSeconds(now());
    return $difference;

    // Convert the difference to minutes, hours, days, or years
    if ($difference < 60) 
    {
        return 'Now';
    }
    elseif ($difference < 3600)
    {
        $minutes = floor($difference / 60);
        return $minutes . ' ' . ($minutes == 1 ? 'minute' : 'minutes') . ' ago';
    }
    elseif ($difference < 86400)
    {
        $hours = floor($difference / 3600);
        return $hours . ' ' . ($hours == 1 ? 'hour' : 'hours') . ' ago';
    }
    elseif ($difference < 31536000)
    {
        $days = floor($difference / 86400);
        return $days . ' ' . ($days == 1 ? 'day' : 'days') . ' ago';
    }
    else
    {
        $years = floor($difference / 31536000);
        return $years . ' ' . ($years == 1 ? 'year' : 'years') . ' ago';
    }
}

// function CheckCourseAlignment($ecom_course)
// {
//     $found = false;
//     $currentUser = auth()->user();
//     $UserIDs = auth()->user()->toArray();
//     // $AlignedIDs = $ecom_course->alignment->toArray();
    
//     if($currentUser->role->id == 1)
//     {
//         return true;
//     }
    
//     $AlignedIDs = $ecom_course->alignment ? $ecom_course->alignment->toArray() : null; // Added null check

//     if ($AlignedIDs) 
//     { 
//         // dd($AlignedIDs);
//         // dd($UserIDs);
//         // $first_ecom_course = ecom_course::find(7);
//         // dd($AlignedIDs);
//         // dd(json_decode($AlignedIDs['upload_csv_json_data']));

//         if($AlignedIDs['zone_name'] != null)
//         {
//             if($UserIDs['zone'] == $AlignedIDs['zone_name'])
//             {
//                 $found =  true; 
//             }
//         }

//         if($AlignedIDs['city_id'] != null)
//         {
//             if($UserIDs['city_id'] == $AlignedIDs['city_id'])
//             {
//                 $found = true;
//             }
//         }
    
//         if($AlignedIDs['branch_id'] != null)
//         {
//             if($UserIDs['branch_id'] == $AlignedIDs['branch_id'])
//             {
//                 $found = true;
//             }
//         }
//         if($AlignedIDs['department_id'] != null)
//         {
//             if($UserIDs['department_id'] == $AlignedIDs['department_id'])
//             {
//                 $found = true;
//             }
//         }
//         if($AlignedIDs['sub_department_id'] != null)
//         {
//             if($UserIDs['department_id'] == $AlignedIDs['sub_department_id'])
//             {
//                 $found = true;
//             }
//         }
//         if($AlignedIDs['role_id'] != null)
//         {
//             if($UserIDs['role_id'] == $AlignedIDs['role_id'])
//             {
//                 $found = true;
//             }
//         }
//         if($AlignedIDs['shift_time_id'] != null)
//         {
//             if($UserIDs['time_slot_id'] == $AlignedIDs['shift_time_id'])
//             {
//                 $found = true;
//             }
//         }
//         if($AlignedIDs['employee_id'] != null)
//         {
//             if($UserIDs['id'] == $AlignedIDs['employee_id'])
//             {
//                 $found = true;
//             }
//         }
//         if($AlignedIDs['instructor_id'] != null)
//         {
//             if($UserIDs['id'] == $AlignedIDs['instructor_id'])
//             {
//                 $found = true;
//             }
//         }
//         if($AlignedIDs['upload_csv_json_data'] != null)
//         {
//             $bulkIds = json_decode($AlignedIDs['upload_csv_json_data']);
            
//             // dd($currentUser);
//             // dd($bulkIds);
//             // dd(isset($bulkIds->ZoneIDs));

//             if(isset($bulkIds->RoleIDs))
//             {
//                 if(in_array($currentUser->role->id, $bulkIds->RoleIDs))
//                 {
//                     $found = true;
//                 }
//             }
//             if(isset($bulkIds->ZoneIDs))
//             {
//                 if($currentUser->zone != null)
//                 {
//                     if(in_array($currentUser->zone, $bulkIds->ZoneIDs))
//                     {
//                         $found = true;
//                     }
//                 }
//             }
//             if(isset($bulkIds->BranchIDs))
//             {
//                 if($currentUser->Branch != null)
//                 {
//                     if(in_array($currentUser->Branch->branch_id, $bulkIds->BranchIDs))
//                     {
//                         $found = true;
//                     }
//                 }
//             }
//             if(isset($bulkIds->EmployeeIDs))
//             {
//                 if($currentUser->id != null)
//                 {
//                     if(in_array($currentUser->id, $bulkIds->EmployeeIDs))
//                     {
//                         $found = true;
//                     }
//                 }
//             }
//             if(isset($bulkIds->InstructorIDs))
//             {
//                 if($currentUser->id != null)
//                 {
//                     if(in_array($currentUser->id, $bulkIds->DepartmentIDs))
//                     {
//                         $found = true;
//                     }
//                 }
//             }
//             if(isset($bulkIds->ScheduleIDs))
//             {
//                 if($currentUser->time_slot_id != null)
//                 {
//                     if(in_array($currentUser->time_slot_id, $bulkIds->ScheduleIDs))
//                     {
//                         $found = true;
//                     }
//                 }
//             }
//             if(isset($bulkIds->DepartmentIDs))
//             {
//                 if($currentUser->department_id != null)
//                 {
//                     if(in_array($currentUser->department_id, $bulkIds->DepartmentIDs))
//                     {
//                         $found = true;
//                     }
//                 }
//             }
//             if(isset($bulkIds->SubDepartmentIDs))
//             {
//                 if($currentUser->department_id != null)
//                 {
//                     if(in_array($currentUser->department_id, $bulkIds->SubDepartmentIDs))
//                     {
//                         $found = true;
//                     }
//                 }
//             }
//         }
//         return $found;
//     }
//     else
//     {
//         return false;
//     }

// }

function CheckAlignment($model, $tablename)
{
    $found = false;
    $currentUser = auth()->user();
    $UserIDs = auth()->user()->toArray();
    // --------- user_management
    // if($currentUser->role->id == 1)
    // {
    //     return true;
    // }
    
    if($tablename == 'course')
    {
        $AlignedIDs = $model->alignment ? $model->alignment->toArray() : null;  // check if alignment set
    }
    else if($tablename == 'notification')
    {
        $AlignedIDs = $model ? $model->toArray() : null; 
        
        //------------ if not assigned to specific source, it is a circular message
        if ($AlignedIDs['zone_code'] === null 
            && $AlignedIDs['city_id'] === null 
            && $AlignedIDs['branch_id'] === null 
            && $AlignedIDs['department_id'] === null 
            && $AlignedIDs['sub_department_id'] === null 
            && $AlignedIDs['role_id'] === null 
            && $AlignedIDs['shift_time_id'] === null 
            && $AlignedIDs['employee_id'] === null 
            && $AlignedIDs['instructor_id'] === null
        ) 
        {
            return true; // it is a circular
        }
    }

    //------------ check who is aligned notify
    if ($AlignedIDs) 
    { 
        // if any of the source is aligned, return true
        if($AlignedIDs['zone_code'] != null)
        {
            if($UserIDs['zone_id'] == $AlignedIDs['zone_code'])
            {
                $found =  true; 
            }
        }
        
        if($AlignedIDs['city_id'] != null)
        {
            if($UserIDs['city_id'] == $AlignedIDs['city_id'])
            {
                $found = true;
            }
        }    

        if($AlignedIDs['branch_id'] != null)
        {
            if($UserIDs['branch_id'] == $AlignedIDs['branch_id'])
            {
                $found = true;
            }
        }

        if($AlignedIDs['department_id'] != null)
        {
            if($UserIDs['department_id'] == $AlignedIDs['department_id'])
            {
                $found = true;
            }
        }
        if($AlignedIDs['sub_department_id'] != null)
        {
            if($UserIDs['sub_department_id'] == $AlignedIDs['sub_department_id'])
            {
                $found = true;
            }
        }

        if($AlignedIDs['role_id'] != null)
        {
            $currentUserRoles = $currentUser->roles->pluck('id')->toArray();
            $AlignedRoleID = $AlignedIDs['role_id'];

            if (in_array($AlignedRoleID, $currentUserRoles)) 
            {
                $found = true;
            } 
         
            // if($UserIDs['role_id'] == $AlignedIDs['role_id'])
            // {
            //     $found = true;
            // }
        }

        if($AlignedIDs['shift_time_id'] != null)
        {
            if($UserIDs['time_slot_id'] == $AlignedIDs['shift_time_id'])
            {
                $found = true;
            }
        }
        if($AlignedIDs['employee_id'] != null)
        {
            if($UserIDs['id'] == $AlignedIDs['employee_id'])
            {
                $found = true;
            }
        }
        if($AlignedIDs['instructor_id'] != null)
        {
            if($UserIDs['id'] == $AlignedIDs['instructor_id'])
            {
                $found = true;
            }
        }

        // dd($UserIDs, $AlignedIDs);
        // dd($UserIDs['sub_department_id'], $AlignedIDs['sub_department_id']);
        // dd($UserIDs['department_id'], $AlignedIDs['department_id']);
        // dd($UserIDs['city_id'], $AlignedIDs['city_id']);
        // dd($UserIDs['zone_id'], $AlignedIDs['zone_code']);
        
        if($tablename == 'course')
        {
            if($AlignedIDs['upload_csv_json_data'] != null)
            {
                $bulkIds = json_decode($AlignedIDs['upload_csv_json_data']);
                
                // change zone to zone_id
                // check how employeeIds are saved from csv


                // dd($currentUser);
                // dd($bulkIds);
                // dd(isset($bulkIds->ZoneIDs));
    
                if(isset($bulkIds->RoleIDs))
                {
                    // check if any of my roles id match with any assigned roles IDs
                    $currentUserRoleIds = $currentUser->roles->pluck('id')->toArray();
                    if (array_intersect($currentUserRoleIds, $bulkIds->RoleIDs))
                    {
                        $found = true;
                    }
                }
                if(isset($bulkIds->ZoneIDs))
                {
                    if($currentUser->zone != null)
                    {
                        if(in_array($currentUser->zone_id, $bulkIds->ZoneIDs))
                        {
                            $found = true;
                        }
                    }
                }
                if(isset($bulkIds->BranchIDs))
                {
                    if($currentUser->Branch != null)
                    {
                        if(in_array($currentUser->Branch->branch_id, $bulkIds->BranchIDs))
                        {
                            $found = true;
                        }
                    }
                }
                if(isset($bulkIds->EmployeeIDs))
                {
                    if($currentUser->id != null)
                    {
                        if(in_array($currentUser->id, $bulkIds->EmployeeIDs))
                        {
                            $found = true;
                        }
                    }
                }
                if(isset($bulkIds->InstructorIDs))
                {
                    if($currentUser->id != null)
                    {
                        if(in_array($currentUser->id, $bulkIds->InstructorIDs))
                        {
                            $found = true;
                        }
                    }
                }
                if(isset($bulkIds->ScheduleIDs))
                {
                    if($currentUser->time_slot_id != null)
                    {
                        if(in_array($currentUser->time_slot_id, $bulkIds->ScheduleIDs))
                        {
                            $found = true;
                        }
                    }
                }
                if(isset($bulkIds->DepartmentIDs))
                {
                    if($currentUser->department_id != null)
                    {
                        if(in_array($currentUser->department_id, $bulkIds->DepartmentIDs))
                        {
                            $found = true;
                        }
                    }
                }
                if(isset($bulkIds->SubDepartmentIDs))
                {
                    if($currentUser->department_id != null)
                    {
                        if(in_array($currentUser->sub_department_id, $bulkIds->SubDepartmentIDs))
                        {
                            $found = true;
                        }
                    }
                }
            }
        }
        
        return $found;
    }
    else
    {
        return false;
    }

}

function GetPercentageOfAssessment($assessment, $passing_ratio)
{
    $totalQuestions = $assessment->count();
    // Calculate the number of correct answers
    $correctAnswers = $assessment->where('status', 1)->count();
    
    // Calculate the percentage of correct answers
    $percentage = ($totalQuestions > 0) ? ($correctAnswers / $totalQuestions) * 100 : 0;
    
    // Define the passing rate
    // $passingRate = 50;
    $passingRate = $passing_ratio;
    
    // Check if the percentage meets or exceeds the passing rate
    $isPassed = $percentage >= $passingRate;
    
    // Output the results
    // echo "assessment: "."<br>";
    // echo "Total Questions: $totalQuestions\n"."<br>";
    // echo "Correct Answers: $correctAnswers\n"."<br>";
    // echo "Percentage: $percentage%\n"."<br>";
    // echo $isPassed ? "Passed" : "Failed <br>";

}
function getUserLectureAssessment($lecture)
{
    $assessments = collect([
        $lecture->AssessmentStatus->where('user_id', auth()->id())->where('assessment_level', 1)->map(function ($item) {
            return ['question_level' => $item->question_level, 'status' => $item->status];
        }),
        $lecture->AssessmentStatus->where('user_id', auth()->id())->where('assessment_level', 2)->map(function ($item) {
            return ['question_level' => $item->question_level, 'status' => $item->status];
        }),
        $lecture->AssessmentStatus->where('user_id', auth()->id())->where('assessment_level', 3)->map(function ($item) {
            return ['question_level' => $item->question_level, 'status' => $item->status];
        }),
        $lecture->AssessmentStatus->where('user_id', auth()->id())->where('assessment_level', 4)->map(function ($item) {
            return ['question_level' => $item->question_level, 'status' => $item->status];
        })
    ]);

    $totalQuestions = 0;
    $totalCorrectAnswers = 0;

    foreach ($assessments as $assessment) 
    {
        if ($assessment->isNotEmpty()) 
        {
            list($percentage, $isPassed) = GetPercentageOfAssessment($assessment, $lecture->passing_ratio);
            $totalQuestions += $assessment->count();
            $totalCorrectAnswers += $assessment->where('status', 1)->count();
            echo "<br><br><br>";
            
        }
    }

    if ($totalQuestions > 0) 
    {
        $overallPercentage = ($totalCorrectAnswers / $totalQuestions) * 100;
        // $overallPassed = $overallPercentage >= 50;
        $overallPassed = $overallPercentage >= $lecture->passing_ratio;
        
        // echo "Overall Assessment:<br>";
        // echo "Total Questions: $totalQuestions<br>";
        // echo "Correct Answers: $totalCorrectAnswers<br>";
        // echo "Overall Percentage: $overallPercentage%<br>";
        // echo $overallPassed ? "Overall Passed<br>" : "Overall Failed<br>";
        return $overallPercentage;
    }
    else
    {
        // echo "No assessments found.<br>";
        return false;
    }
}
