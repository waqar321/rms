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

    // upload on portal----------------
    // // $file = $request->file('file_name');
    // $imagePath = null;
    // if ($file) 
    // // if (!empty($file)) .
    // {
    //     // dd($file);

    //     $imageResponse = ImageUploadOnLeopardsWebFtp($file);
    //     // dd($imageResponse);

    //     $response = json_decode($imageResponse);
    //     if ($response->success == true) {
    //         $imagePath = $response->file_path;
    //     }
    // }
    
}
function ImageUploadOnLeopardsWebFtp($file)
{
    ini_set('memory_limit', '1024M'); // Increase memory limit to 1GB

    $filePath = $file->getRealPath();   // Get the real path of the temporary file

    $handle = fopen($filePath, 'rb');
    if ($handle === false) {
        throw new \Exception('Failed to open the file for reading.');
    }

    // Initialize a variable to store the base64-encoded data
    $base64Data = '';

    // Read the file in chunks and encode each chunk in base64
    while (!feof($handle)) 
    {
        $chunk = fread($handle, 8192); // Read 8KB at a time
        if ($chunk === false) {
            throw new \Exception('Error reading the file.');
        }
        $base64Data .= base64_encode($chunk);
    }

    // Close the file handle
    fclose($handle);

    $curl = curl_init();

    curl_setopt_array($curl, array(
        // CURLOPT_URL => 'https://www.leopardscourier.com/ticket_attachments.php',
        CURLOPT_URL => 'https://www.leopardscourier.com/lms_videos_upload.php',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => array('video' => $base64Data, 'extension' => pathinfo($filePath, PATHINFO_EXTENSION)),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    return $response;

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
