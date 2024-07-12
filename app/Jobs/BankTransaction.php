<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\Models\Admin\ecom_bank_transaction;
use App\Models\Admin\ecom_booking;
use App\Models\Admin\ecom_bank_transaction_import;
use App\Models\Admin\ecom_booking_deposits;
use App\Models\Admin\ecom_activity_remark;

class BankTransaction implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $request;
    protected $user;
    protected $spreadsheet;
    protected $file_id;

    public function __construct($request,$user,$file_id,array $spreadsheet)
    {
        $this->queue = 'bank_transaction';
        $this->request =  $request;
        $this->user =  $user;
        $this->spreadsheet =  $spreadsheet;
        $this->file_id = $file_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $is_valid = 0;
        $is_duplicate = 0;
        $invalid_count=0;
        $count_not_matched = 0;
        $count_duplicated = 0;
        $verified = 0;

        $data=[];
        $Cns = array_column($this->spreadsheet , 9); //Fetching Index from xls

        $CnsResult =  ecom_booking::select('id','booked_packet_collect_amount','cn_short')->whereIn('cn_short',$Cns);
        $getcn_short = $CnsResult->pluck('cn_short')->toArray();
        $getBookCollectAmount = $CnsResult->pluck('booked_packet_collect_amount')->toArray();
        $getBookingIds = $CnsResult->pluck('id')->toArray();

        $cnTransactionResult = ecom_bank_transaction::whereIn('cn_short',$getcn_short);
        $getcnTransactionCns = $cnTransactionResult->pluck('cn_short')->toArray();

        $bookingDeposits = ecom_booking_deposits::whereIn('booking_id',$getBookingIds);
        $depositIds = $bookingDeposits->groupBy('booking_id')->pluck('booking_id')->toArray();

        $depositAmount = $bookingDeposits->groupBy('booking_id')
        ->selectRaw('booking_id,sum(deposited_amount) as total_deposited_amount')
        ->pluck('total_deposited_amount','booking_id')
        ->toArray();

        $duplicateCNs=[];
        $validCNs=[];
        $deposit_data_insert =[];
        $deposit_data_update =[];

        foreach ($this->spreadsheet as $key2 => $spreadsheet_row) {

            $checkvalidcn = strlen($spreadsheet_row[9]);

            if($checkvalidcn < 10){
                $is_valid = 1;
                $cn_short = (int)$spreadsheet_row[9];
                $validCNs[] = $cn_short;
            }
            else{
                $invalid_count++;
                $is_valid = 0;
                $booking_id = NULL;
                // continue;
            }

            if(!in_array($cn_short ,$getcn_short)){
                $count_not_matched ++;
                $is_valid = 0;
                $booking_id = NULL;
                //continue;
            }else{

                $SearchCnkey = array_search($cn_short, $getcn_short);

                $cod_amount = $getBookCollectAmount[$SearchCnkey];
                $booking_id = $getBookingIds[$SearchCnkey];
                $amount = (double) str_replace(',', '', $spreadsheet_row[6]);
                if($cod_amount == $amount || ($cod_amount+1) == $amount || ($cod_amount-1) == $amount){
                    $verified = 1;
                }

                if(empty($depositAmount[$booking_id]) || $depositAmount[$booking_id]==0){
                    $deposit_data_insert[$key2] =[
                        'booking_id' => $booking_id,
                        'deposited_amount' =>$amount,
                        'created_at' => date('Y-m-d H:i:s'),
                    ];
                    $deposit_data_insert[$key2]['active_for_pay'] = 0;
                    if($cod_amount <= $amount){
                        $deposit_data_insert[$key2]['active_for_pay'] = 1;
                    }
                }
                else{
                    $total_deposited_amount = $depositAmount[$booking_id]+$amount;
                    $deposit_data_update[$key2] =[
                        'booking_id' => $booking_id,
                        'deposited_amount' =>$total_deposited_amount,
                        'created_at' => date('Y-m-d H:i:s'),
                    ];
                    if($cod_amount==$total_deposited_amount){
                        $deposit_data_update[$key2]['active_for_pay'] = 1;
                    }
                }
            }
            $is_duplicate = 0;
            if(in_array($cn_short ,$getcnTransactionCns)){
                $count_duplicated ++;
                $is_duplicate = 1;
                $duplicateCNs[] = $cn_short;
            }

            $data[] = [
                'branch_code' => $spreadsheet_row[0],
                'branch_name' => $spreadsheet_row[1],
                'deposit_slip_no' => $spreadsheet_row[2],
                'date_collection' => $spreadsheet_row[3],
                'payment_mode' => $spreadsheet_row[4],
                'instrument_no' => $spreadsheet_row[5],
                'amount' => (double) str_replace(',', '', $spreadsheet_row[6]), //(double)$spreadsheet_row[6],
                'date_credit' => $spreadsheet_row[7],
                'origin_description' => $spreadsheet_row[8],
                'cn_short' => $spreadsheet_row[9],
                'booking_id' =>$booking_id,
                'is_valid' => $is_valid,
                'is_duplicate' => $is_duplicate,
                'admin_user_id' => $this->user->id,
                'is_verified' => $verified,
                'created_at' => date('Y-m-d H:i:s'),
            ];

            $remarks[] = array(
                'remark_type' => 'bank_transaction',
                'entity_id' => $booking_id,
                'instance_id' => $this->user->id,
                'instance_type' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'remark_text' => 'Bank Transaction Added Through Import CSV.'
            );

        }

        $last_batch = ecom_bank_transaction_import::where('created_at','like',date('Y-m-d')."%")
        ->orderBy('id','DESC')
        ->first(['batch_no']);

        if(empty($last_batch)){
            $batch_no = 1;
        }
        else{
            $batch_no = $last_batch->batch_no+1;
        }

        $batch_data = [
            'batch_date' => date('Y-m-d'),
            'file_id' => $this->file_id,
            'batch_no' => $batch_no,
            'invalid_record' => $invalid_count,
            'matched_record' => count($this->spreadsheet) - $count_not_matched,
            'non_matched_record' => $count_not_matched,
            'non_duplicate' => count($this->spreadsheet) -  $count_duplicated,
            'duplicate' => $count_duplicated
        ];

        $importTransaction = ecom_bank_transaction_import::create($batch_data);

        $finalData = array_map(function($subArray) use ($importTransaction,$batch_no) {
            $subArray['batch_no'] = $batch_no;
            $subArray['bank_transaction_import_id'] = $importTransaction->id;
            return $subArray;
        }, $data);

        if(count($finalData) > 0 ){
            ecom_bank_transaction::insert($finalData);
            ecom_booking::whereIn('cn_short',$validCNs)->update(['is_valid'=>1,'payment_received'=>1]);
            ecom_booking::whereIn('cn_short',$duplicateCNs)->update(['is_duplicate'=>1]);

           if(!empty($deposit_data_insert)) ecom_booking_deposits::insert($deposit_data_insert);
           if(!empty($remarks)) ecom_activity_remark::insert($remarks);

           if(!empty($deposit_data_update)){
                // Iterate through the data to update
                foreach ($deposit_data_update as $deposit_data) {
                    ecom_booking_deposits::where('booking_id', $deposit_data['booking_id'])->update([
                        'deposited_amount' => $deposit_data['deposited_amount'],
                        'active_for_pay' => isset($deposit_data['active_for_pay']) ? 1 : 0
                    ]);
                }
           }
        }
    }
}
