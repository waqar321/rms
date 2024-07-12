<?php

namespace App\Jobs\Api;

use App\Models\Admin\Zone;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Support\Facades\DB;

class FetchZoneApiDataJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct()
    {
        // DB::transaction(function () 
        // {
        //     DB::table('zone')->delete();
        // });
    }
    public function handle()
    {
        $latestId = Zone::latest()->value('id');
        $latestId++;
        
        // $response = Http::get('http://172.16.0.13/HR/Api/getallzone.aspx');
        $response = Http::get('http://leopardsweb.com/HR/Api/getallzone.aspx');

        if ($response->successful()) 
        {
            $zones = $response->json();

            foreach ($zones as $zone) 
            {
                Zone::updateOrCreate([
                        'zone_code' => $zone['ZoneId'],
                        'zone_name' => $zone['ZoneName'],
                        'zone_short_name' => $zone['ShortName']
                    ]);
            }

            Log::info('Zone data saved successfully');
        } else {
            Log::error('Failed to fetch Zone data');
        }
    }
}
