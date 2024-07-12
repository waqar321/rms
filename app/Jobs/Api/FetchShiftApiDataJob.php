<?php

namespace App\Jobs\Api;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use App\Models\Admin\ecom_employee_time_slots;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Support\Facades\DB;

class FetchShiftApiDataJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct()
    {
        // DB::transaction(function () 
        // {
        //     DB::table('ecom_employee_time_slots')->delete();
        // });
    }

    public function handle()
    {
        $latestId = ecom_employee_time_slots::latest()->value('id');
        $latestId++;

        // $response = Http::get('http://172.16.0.13/HR/Api/shiftdetail.aspx');
        $response = Http::get('http://leopardsweb.com/HR/Api/shiftdetail.aspx');

        if ($response->successful()) 
        {
            $shifts = $response->json();
        
            foreach ($shifts as $shift) 
            {
                ecom_employee_time_slots::updateOrCreate([
                    'shift_code' => $shift['Code'],
                    'start_time' => $shift['Start_Time'],
                    'end_time' => $shift['End_Time'],
                ]);
            }

            Log::info('Shift data saved successfully');
        } else {
            Log::error('Failed to fetch Shift data');
        }

    }
}
