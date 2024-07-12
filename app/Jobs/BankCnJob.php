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
class BankCnJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    
    protected $request;
    protected $user;
    public function __construct($request,$user)
    {
        $this->queue = 'add_cn';
        $this->request =  $request;
        $this->user =  $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        DB::beginTransaction();
        try {
        $cityObj = ecom_city::getCityById($this->request['city_id'], "admin");
        $bulk_data = array();

        for ($loop = $this->request['register_cert_no_start']; $loop <= $this->request['register_cert_no_end']; $loop++) {

            $bulk_data[] = array(
                'cn_without_prefix' => $loop,
                'cn_with_prefix' => strtoupper(substr($cityObj->city_abbr, 0, 2)) . sprintf('%08d', $loop),
                'city_id' => $this->request['city_id'],
                'admin_user_id' => $this->user['id'],
                'isCSV' => $this->request['isCSV'],
                'shipment_type_id' => $this->request['shipment_type_id'],
                'created_at' => date('Y-m-d H:i:s'),
            );

        }
        if(count($bulk_data) > 0) {
            DB::table('ecom_bank_cn')->insert($bulk_data);
        }

        DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw $e; // Optionally rethrow the exception
        }
    }
}
