<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class AsimTesting implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        for($i=0;$i<50000;$i++)
        {
            Log::info('Processing item: ' . $i); 
            // print storage log here 
            // $user         =  new User();
            // $user->name   =  'Developer Corner';
            // $user->email   =  'developerCorner'.$i.'@yopmail.com';
            // $user->password = Hash::make('1234');
            // $user->save();
        }
    }
}
