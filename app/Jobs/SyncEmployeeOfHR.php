<?php

namespace App\Jobs;

use App\Models\Admin\ecom_bank_cn;
use App\Models\Admin\ecom_city;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use DB;

class SyncEmployeeOfHR implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $request;
    protected $employeeApiOfHR;

    public function __construct($employeeApiOfHR)
    {
        $this->employeeApiOfHR = $employeeApiOfHR;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // awdawd 
        // json 
        // creation 

        // storage::log(''awdawdawd)
    }
}
