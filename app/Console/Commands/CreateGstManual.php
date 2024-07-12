<?php

namespace App\Console\Commands;

use App\Models\Admin\CronJob;
use Illuminate\Console\Command;
use DB;
class CreateGstManual extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'default:create_gst_invoice';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $cron_job = new CronJob();
        $cron_job->status = 1;
        $cron_job->cron_name = 'default:create_gst_invoice';
        $cron_job->created_at =  date('Y-m-d H:i:s');

        $province = [1,2,14,4,3,3,4,14,2,1];
        $account_no = [540636,540636,54063,540636,540636,2747,2747,2747,2747,2747];
        $current_date = date('Y-m-d');
        foreach ($province as $key=>$value) {
            $ac = $account_no[$key];
            DB::select("CALL admin_createGSTInvoice_manually(?,?,?,?)", [$ac,"$province[$key]","$current_date",'7009']);
        }


        $cron_job->updated_at =  date('Y-m-d H:i:s');
        $cron_job->save();
    }
}
