<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\Api\FetchEmployeeApiDataJob;
use App\Jobs\Api\FetchDepartmentApiDataJob;
use App\Jobs\Api\FetchZoneApiDataJob;
use App\Jobs\Api\FetchCityApiDataJob;
use App\Jobs\Api\FetchShiftApiDataJob;

class SyncHRData extends Command
{
    protected $signature = 'sync:hrData';

    protected $description = 'Command sync the hr data';

    public function handle()
    {
        FetchDepartmentApiDataJob::dispatch();
        FetchZoneApiDataJob::dispatch();
        FetchCityApiDataJob::dispatch();
        FetchShiftApiDataJob::dispatch();
        FetchEmployeeApiDataJob::dispatch();
        
        $this->info('HR data has neem synced.');  

        return Command::SUCCESS;
    }
}

