<?php

namespace App\Console\Commands;

use App\Models\Admin\ecom_booking;
use App\Models\Admin\ecom_booked_packet_history;
use App\Models\Admin\KYC\lss_ref_fuel_charges;
use App\Models\Admin\KYC\lss_ref_rate_matrix_corporate;
use Illuminate\Console\Command;
use DB;
use App\Models\Admin\CronJob;

class updateEachStatusThreeMonth extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'default:update-each-status-three-month';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'COD Update Each Status Three Month';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $cron_job = new CronJob();
        $cron_job->status = 1;
        $cron_job->cron_name = 'default:update-each-status-three-month';
        $cron_job->created_at =  date('Y-m-d H:i:s');

        $days_update = 90;
        $start_date = date('Y-m-d H:i:s', strtotime(date('Y-m-d') . ' -' . $days_update . ' days'));
        $end_date = date('Y-m-d H:i:s');

        $bookedPacketList = array();

        $bookedPackets = ecom_booking::select('booked_packet_cn')
            ->whereIn('booked_packet_status',[0, 2, 4, 5, 6, 8, 9,10, 14, 16, 17,18,19,20]) //  •	No changes in status reflects once terminal status is updated (DV, DS, DW, RW & RV.) or DS ,•	Once RO and RT are performed, shipment stands at being return. ; •	Any terminal Status does not get changed or modified once an invoice is generated.
            ->where('is_active', 1)
            ->where('is_deleted', 0)
            ->whereBetween('booked_packet_date', [$start_date, $end_date])
            //->whereIn('booked_packet_cn',['KI750000336','KI750000451','KI750000348','KI750000276'])
//            ->whereNotIn('merchant_id', [2747, 560158, 557569]);
            ->whereNotIn('merchant_id', [2747, 560158]);

        if($bookedPackets->exists()) {
            $bookedPacketList = $bookedPackets->pluck('booked_packet_cn')->toArray();

            $chunkSize = 10000;
            $totalItems = count($bookedPacketList);
            for ($offset = 0; $offset < $totalItems; $offset += $chunkSize) {
                $chunk = array_slice($bookedPacketList, $offset, $chunkSize);
                $dp_query = DB::connection('oms')->table('book_dispatch')->select('cn_number', 'COUR_ID', 'Cour_Name', 'BOOK_DATE', 'BOOK_TIME', 'ORIGON_CITY_ID', 'DEST_CITY_ID', 'STATUS_CODE as STATUS')
                    ->whereIn('cn_number', $chunk)
                    ->where('STATUS_CODE', '!=', 'CB')
                    ->orderBy('BOOK_DATE', 'DESC')
                    ->orderBy('BOOK_TIME', 'DESC');

                $dispatch_list = array();
                if ($dp_query->exists()) {

                    foreach ($dp_query->get() as $row) {
                        $data = [];
                        $data = array(
                            'activity_date_time' => $row->BOOK_DATE . ' ' . $row->BOOK_TIME,
                            'ACTIVITY_DATE' => $row->BOOK_DATE,
                            'activity_time' => $row->BOOK_TIME,
                            'STATUS' => $row->STATUS,
                            'REASON' => '',
                            'RECEIVER_NAME' => '',
                            'CN_NUMBER' => $row->cn_number,
                        );
                        $dispatch_list[] = $data;
                    }
                }
                //Arrival
                $db_query_ari = DB::connection('oms')->table('arival')
                    ->select('cn_number', 'COURIER_ID', 'Cour_Name', 'ARVL_VIA', 'ARVL_DEST', 'STATUS', 'REASON', 'RECEIVER_NAME', 'ACTIVITY_DATE', 'ACTIVITY_TIME', 'DELIVERY_DATE', 'DELIVERY_TIME')
                    ->whereIn('cn_number', $chunk)
                    ->orderBy('ACTIVITY_DATE', 'DESC')
                    ->orderBy('ACTIVITY_TIME', 'DESC');
                $arrival_list = [];
                // Define $all_stations and $all_statuses here if needed

                if ($db_query_ari->exists()) {
                    foreach ($db_query_ari->get() as $row) {
                        $data = [];
                        $data = array(
                            'REASON' => $row->REASON,
                            'RECEIVER_NAME' => $row->RECEIVER_NAME,
                            'CN_NUMBER' => $row->cn_number,
                            'STATUS' => $row->STATUS,
                        );

                        if ($row->STATUS == 'DV') {
                            $data['activity_date_time'] = $row->DELIVERY_DATE . ' ' . $row->DELIVERY_TIME;
                            $data['ACTIVITY_DATE'] = $row->DELIVERY_DATE;
                            $data['activity_time'] = $row->DELIVERY_TIME;
                        } else {
                            $data['activity_date_time'] = $row->ACTIVITY_DATE . ' ' . $row->ACTIVITY_TIME;
                            $data['ACTIVITY_DATE'] = $row->ACTIVITY_DATE;
                            $data['activity_time'] = $row->ACTIVITY_TIME;
                        }

                        $arrival_list[] = $data;

                    }
                }

                $trackingStatus = array_merge($arrival_list, $dispatch_list);
                uasort($trackingStatus, function ($a, $b) {
                    return $b['activity_date_time'] <=> $a['activity_date_time'];
                });

                // Use array_reduce to find the last activity for each CN
                $lastActivities = array_reduce($trackingStatus, function ($carry, $item) {
                    $cn = $item['CN_NUMBER'];
                    $activityDate = $item['ACTIVITY_DATE'];
                    $activityTime = $item['activity_time'];
                    $activityStatus = $item['STATUS'];
                    $activityReason = $item['REASON'];
                    $recieverName = $item['RECEIVER_NAME'];

                    $key = $cn;
                    if (isset($carry[$key])) {
                        list($lastActivityDate, $lastActivityTime) = $carry[$key];
                        $currentDateTime = strtotime("$activityDate $activityTime");
                        $lastDateTime = strtotime("$lastActivityDate $lastActivityTime");

                        // Compare dates and times to find the most recent activity
                        if ($currentDateTime > $lastDateTime) {
                            $carry[$key] = [$activityDate, $activityTime, $activityStatus, $activityReason, $recieverName];
                        }
                    } else {
                        $carry[$key] = [$activityDate, $activityTime, $activityStatus, $activityReason, $recieverName];
                    }

                    return $carry;
                }, []);

                // Convert the associative array to a sequential array
                $lastActivities = array_map(function ($cn, $activity) {
                    return [
                        'CN_NUMBER' => $cn,
                        'ACTIVITY_DATE' => $activity[0],
                        'activity_time' => $activity[1],
                        'STATUS' => $activity[2],
                        'REASON' => $activity[3],
                        'RECEIVER_NAME' => $activity[4]
                    ];
                }, array_keys($lastActivities), $lastActivities);

                // $lastActivities now contains the last activity for each CN

                $dp_array = $ac_array = $ar_array = $rn_array = $ld_array = $pn_array = $cd_array = $ds_array = $ds_array = $dv_array = $ro_array = array();
                foreach ($lastActivities as $row) {
                    $row = (object)$row;
                    switch ($row->STATUS) {
                        case 'AC':
                            $ac_array[] = [
                                'cn_number' => $row->CN_NUMBER,
                                'delivery_date' => $row->ACTIVITY_DATE,
                            ];
                            break;
                        case 'AR':
                            $ar_array[] = [
                                'cn_number' => $row->CN_NUMBER,
                                'delivery_date' => $row->ACTIVITY_DATE,
                            ];
                            break;
                        case 'RN':
                        case 'NR':
                            $rn_array[] = [
                                'cn_number' => $row->CN_NUMBER,
                                'reason' => addslashes($row->REASON)
                            ];
                            break;
                        case 'LD':
                            $ld_array[] = [
                                'cn_number' => $row->CN_NUMBER,
                            ];
                            break;
                        case 'PN':
                            $pn_array[] = [
                                'cn_number' => $row->CN_NUMBER,
                                'reason' => addslashes($row->REASON),
                                'receiver_name' => addslashes($row->RECEIVER_NAME),
                                'delivery_date' => $row->ACTIVITY_DATE,
                            ];
                            break;
                        case 'RV':
                        case 'RW':
                        case 'DR':
                        case 'DW':
                        case 'DS':
                            $ds_array[] = [
                                'cn_number' => $row->CN_NUMBER,
                                'receiver_name' => addslashes($row->RECEIVER_NAME),
                                'reason' => ($row->REASON ? addslashes($row->REASON) : ''),
                                'date_return' => $row->ACTIVITY_DATE
                            ];
                            break;
                        case 'DV':
                            $dv_array[] = [
                                'cn_number' => $row->CN_NUMBER,
                                'delivery_date' => $row->ACTIVITY_DATE,
                                'reason' => ($row->REASON ? addslashes($row->REASON) : ''),
                                'receiver_name' => addslashes($row->RECEIVER_NAME),
                            ];
                            $dv_cns[] = [
                                'cn_number' => $row->CN_NUMBER,
                                'reason' => ($row->REASON ? addslashes($row->REASON) : ''),
                                'receiver_name' => addslashes($row->RECEIVER_NAME),
                                'delivery_date' => $row->ACTIVITY_DATE,
                            ];
                            break;
                        case 'DP':
                            $dp_array[] = [
                                'cn_number' => $row->CN_NUMBER,
                                'reason' => ($row->REASON ? addslashes($row->REASON) : ''),
                                'receiver_name' => addslashes($row->RECEIVER_NAME),
                                'delivery_date' => $row->ACTIVITY_DATE,
                            ];
                            break;
                        case 'RO':
                            $ro_array[] = [
                                'cn_number' => $row->CN_NUMBER,
                                'reason' => ($row->REASON ? addslashes($row->REASON) : ''),
                                'receiver_name' => addslashes($row->RECEIVER_NAME),
                                'delivery_date' => $row->ACTIVITY_DATE,
                            ];
                            break;
                        default:
                            $pn_array[] = [
                                'cn_number' => $row->CN_NUMBER,
                                'reason' => ($row->REASON ? addslashes($row->REASON) : ''),
                                'receiver_name' => addslashes($row->RECEIVER_NAME),
                                'delivery_date' => $row->ACTIVITY_DATE,
                            ];
                            break;
                    }
                }

                // dd($dp_array,$ld_array,$ar_array,$ac_array,$dv_array,$pn_array,$rn_array,$ro_array,$ds_array);
                $mainQuery = '';
                $mainQuery .= (!empty($dp_array) ? $this->generateUpdateQuery($dp_array, '14') : ''); // Dispatched
                $mainQuery .= (!empty($ld_array) ? $this->generateUpdateQuery($ld_array, '8') : ''); // Missroute
                $mainQuery .= (!empty($ar_array) ? $this->generateUpdateQuery($ar_array, '6') : ''); // Arrived at Station
                $mainQuery .= (!empty($ac_array) ? $this->generateUpdateQuery($ac_array, '5') : ''); // Assign To Courier
                $mainQuery .= (!empty($dv_array) ? $this->generateUpdateQuery($dv_array, '12', $dv_cns) : ''); // Delivered
                $mainQuery .= (!empty($pn_array) ? $this->generateUpdateQuery($pn_array, '9') : ''); // Pending
                $mainQuery .= (!empty($rn_array) ? $this->generateUpdateQuery($rn_array, '16') : ''); // Ready For Return
                $mainQuery .= (!empty($ro_array) ? $this->generateUpdateQuery($ro_array, '17') : ''); // Being Return
                $mainQuery .= (!empty($ds_array) ? $this->generateUpdateQuery($ds_array, '7') : ''); // Returned To Shipper
                echo 'success';
            }

        }
        $cron_job->updated_at = date('Y-m-d H:i:s');
        $cron_job->save();
    }

    public function generateUpdateQuery($cnList, $status, $cns = []) {

        $cn_string = $dv_cn_string = '';

        if (sizeof($cnList) > 0) {

            if ($status==7) {

                foreach($cnList as $returnedStatuses){

                    ecom_booking::where('booked_packet_cn',$returnedStatuses['cn_number'])->update(['booked_packet_status'=>7,'return_reason'=>$returnedStatuses['reason'],'status_update_date'=>date('Y-m-d H:i:s'),'packet_received_by'=>$returnedStatuses['receiver_name'],'date_return'=>$returnedStatuses['date_return']]);

                    $bookingData = ecom_booking::where('booked_packet_cn', $returnedStatuses['cn_number'])
                        ->leftJoin('ecom_merchant as em', 'em.id', '=', 'ecom_bookings.merchant_id')
                        ->leftJoin('service_view as sv', 'sv.shipment_type_id', '=', 'ecom_bookings.shipment_type_id')
                        ->select(
                            'ecom_bookings.origin_city',
                            'ecom_bookings.destination_city',
                            'ecom_bookings.shipment_type_id',
                            'ecom_bookings.booked_packet_status',
                            'ecom_bookings.booked_packet_weight',
                            'ecom_bookings.arival_dispatch_weight',
                            'ecom_bookings.booked_packet_collect_amount',
                            'sv.service_code',
                            'ecom_bookings.zone_name AS rating_zone',
                            'em.merchant_account_no',
                            'ecom_bookings.booked_packet_date'
                        )->first();

                    if($bookingData->service_code=="FO") $bookingData->service_code = "GO";
                    //packet_charges
                    $packageMaxWeight = max($bookingData->arival_dispatch_weight,$bookingData->booked_packet_weight);

                    $teriff = lss_ref_rate_matrix_corporate::getTariffRow2($bookingData->origin_city,$bookingData->service_code,$bookingData->rating_zone,$packageMaxWeight,$bookingData->merchant_account_no,$bookingData->booked_packet_date); //put arrival dispatch weight here

                    if(!empty($teriff)) {

                        $booked_packet_charges =0;
                        $return_charges =0;

                        if (isset($teriff->add_weight)) {
                            $toWeight = $teriff->to_weight;
                            $parcelWeight = $packageMaxWeight;

                            if ($teriff->add_weight == 0 || $toWeight > $parcelWeight) {
                                $booked_packet_charges = $teriff->tarrif_rate;
                            } else {
                                $fromWeight = $teriff->to_weight;
                                $additionalWeight = $teriff->add_weight;
                                $additionalWeightRate = $teriff->add_charges;
                                $tariffRate = $teriff->tarrif_rate;

                                $remainingWeight = $parcelWeight - $fromWeight;
                                $remainder = $remainingWeight % $additionalWeight;
                                if ($remainder < $additionalWeight) {
                                    $differenceWeight = $additionalWeight - $remainder;
                                    $totalWeight = $remainingWeight + $differenceWeight;
                                    $weightChunks = $totalWeight / $additionalWeight;
                                    if ($remainder == 0) {
                                        $weightChunks = $remainingWeight / $additionalWeight;
                                    }

                                    $booked_packet_charges = ($tariffRate + ($weightChunks * $additionalWeightRate)); // Setting total with weight calculation
                                }
                            }
                        }

                        if($status==7){
                            if (isset($teriff->add_weight)) {
                                if ($teriff->add_weight == 0 || $toWeight > $parcelWeight) {
                                    $return_charges = $teriff->return_rate;
                                } else {
                                    $parcelWeight = $packageMaxWeight;
                                    $fromWeight = $teriff->to_weight;
                                    $additionalWeight = $teriff->add_weight;
                                    $additionalWeightRate = $teriff->add_charges;
                                    $tariffRate = $teriff->return_rate;

                                    $remainingWeight = $parcelWeight - $fromWeight;
                                    $remainder = $remainingWeight % $additionalWeight;
                                    if ($remainder < $additionalWeight) {
                                        $differenceWeight = $additionalWeight - $remainder;
                                        $totalWeight = $remainingWeight + $differenceWeight;
                                        $weightChunks = $totalWeight / $additionalWeight;
                                        if ($remainder == 0) {
                                            $weightChunks = $remainingWeight / $additionalWeight;
                                        }

                                        $return_charges = ($tariffRate + ($weightChunks * $additionalWeightRate)); // Setting total with weight calculation
                                    }
                                }
                            }
                            $booked_packet_charges = $return_charges;
                        }

                        $total = (float) $booked_packet_charges;
                        $rateArray['booked_packet_charges'] = $total;
                        $rateArray['packet_charges'] = $total;
                        $rateArray['return_charges'] = $return_charges;
                        $rateArray['updated_at'] = date('Y-m-d H:i:s');
                        $update =  ecom_booking::where('booked_packet_cn',$returnedStatuses['cn_number'])->update($rateArray);
                    }


                    $statusHistoryData = [
                        'cn_number' => $returnedStatuses['cn_number'],
                        'status' => 7,
                        'reason' => $returnedStatuses['reason'],
                        'shipping_date' => date('Y-m-d H:i:s'),
                        'created_at' => date('Y-m-d H:i:s')
                    ];

                    ecom_booked_packet_history::insert($statusHistoryData);
                }

            } else if ($status==16) {

                $cns = array_column($cnList, "cn_number");
                $notonPendingList =  ecom_booking::whereIn('booked_packet_cn',$cns)
                    ->whereNotIn('booked_packet_status',[16,17])
                    ->pluck('booked_packet_cn')->toArray();

                // Use array_intersect to find common values
                $common_cn_numbers = array_intersect($cns, $notonPendingList);

                // Use array_filter to filter elements based on common "cn_number" values
                $matchingElements = array_filter($cnList, function ($element) use ($common_cn_numbers) {
                    return in_array($element['cn_number'], $common_cn_numbers);
                });

                foreach($matchingElements as $beingReturnedStatuses){

                    ecom_booking::where('booked_packet_cn',$beingReturnedStatuses['cn_number'])->update(['booked_packet_status'=>16,'return_reason'=>$beingReturnedStatuses['reason'],'status_update_date'=>date('Y-m-d H:i:s')]);

                    $statusHistoryData = [
                        'cn_number' => $beingReturnedStatuses['cn_number'],
                        'status' => 16,
                        'reason' => $beingReturnedStatuses['reason'],
                        'shipping_date' => date('Y-m-d H:i:s'),
                        'created_at' => date('Y-m-d H:i:s')
                    ];

                    ecom_booked_packet_history::insert($statusHistoryData);
                }

            } else if ($status == 12) {
                foreach($cnList as $deliveredStatuses){

                    ecom_booking::where('booked_packet_cn',$deliveredStatuses['cn_number'])->update(['booked_packet_status'=>12,'return_reason'=>$deliveredStatuses['reason'],'status_update_date'=>date('Y-m-d H:i:s'),'delivery_date'=>$deliveredStatuses['delivery_date'],'packet_received_by'=>$deliveredStatuses['receiver_name']]);

                    $statusHistoryData = [
                        'cn_number' => $deliveredStatuses['cn_number'],
                        'status' => 12,
                        'reason' => $deliveredStatuses['reason'],
                        'shipping_date' => date('Y-m-d H:i:s'),
                        'created_at' => date('Y-m-d H:i:s')
                    ];

                    ecom_booked_packet_history::insert($statusHistoryData);
                }
            } else if ($status == 9) {

                $cns = array_column($cnList, "cn_number");
                $notonPendingList =  ecom_booking::whereIn('booked_packet_cn',$cns)
                    ->whereNotIn('booked_packet_status',[9,17])
                    ->pluck('booked_packet_cn')->toArray();

                // Use array_intersect to find common values
                $common_cn_numbers = array_intersect($cns, $notonPendingList);

                // Use array_filter to filter elements based on common "cn_number" values
                $matchingElements = array_filter($cnList, function ($element) use ($common_cn_numbers) {
                    return in_array($element['cn_number'], $common_cn_numbers);
                });

                foreach($matchingElements as $pendingStatuses){
                    ecom_booking::where('booked_packet_cn',$pendingStatuses['cn_number'])
                        ->whereNotIn('booked_packet_status',[9])
                        ->update(['booked_packet_status'=>9,'return_reason'=>$pendingStatuses['reason'],'status_update_date'=>date('Y-m-d H:i:s')]);
                    $statusHistoryData = [
                        'cn_number' => $pendingStatuses['cn_number'],
                        'status' => 9,
                        'reason' => $pendingStatuses['reason'],
                        'shipping_date' => date('Y-m-d H:i:s'),
                        'created_at' => date('Y-m-d H:i:s')
                    ];

                    ecom_booked_packet_history::insert($statusHistoryData);
                }
            } else {

                $cns = array_column($cnList, "cn_number");
                ecom_booking::whereIn('booked_packet_cn',$cns)
                    ->whereNotIn('booked_packet_status',[$status,17])
                    ->update(['booked_packet_status'=>$status,'status_update_date'=>date('Y-m-d H:i:s')]);

                foreach($cnList as $otherStatuses){
                    $statusHistoryData[] = [
                        'cn_number' => $otherStatuses['cn_number'],
                        'status' => $status,
                        'shipping_date' => $otherStatuses['delivery_date'],
                        'created_at' => date('Y-m-d H:i:s')
                    ];
                }
                ecom_booked_packet_history::insert($statusHistoryData);
            }
        } else {

            echo '<br/><br/>Empty Array of Status: ' . $status . ' <br/><br/> ';

            return '';
        }

    }

}
