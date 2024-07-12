<?php

namespace App\Jobs\Api;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use App\Models\Admin\central_ops_city;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Support\Facades\DB;

class FetchCityApiDataJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    public function __construct()
    { 
        
        // DB::transaction(function () 
        // {
        //     DB::table('central_ops_city')->delete();
        // });
    }
    public function handle()
    {
        // $response = Http::get('http://172.16.0.13/HR/Api/getallcity.aspx');
        $response = Http::get('http://leopardsweb.com/HR/Api/getallcity.aspx');

        if ($response->successful())
        {
            $cities = $response->json();

            foreach ($cities as $city) 
            {
                central_ops_city::updateOrCreate([
                    'city_id' => $city['CityId'],
                    'city_name' => $city['CityName'],
                    'City_Short_Name' => $city['ShortName'],
                    'zone_code' => $city['ZoneId']
                ]);
            }

            Log::info('City data saved successfully');
        }
        else 
        {
            Log::error('Failed to fetch City data');
        }
    }
}
