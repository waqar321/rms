<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Admin\ecom_admin_user;
use App\Models\Admin\Zone;
use App\Models\Admin\ecom_employee_time_slots;
use App\Models\Admin\central_ops_city;
use App\Models\Admin\ecom_booking;
use App\Models\Admin\ecom_invoice;
use App\Models\Admin\ecom_course;
use App\Models\Admin\ecom_category;
use App\Models\Admin\ecom_department;
use App\Models\Admin\ecom_invoice_booked_packets;
use App\Models\Admin\ecom_news;
use App\Models\Admin\ecom_notification;
use App\Models\Admin\ecom_lecture;
use App\Models\Admin\Role;
use App\Models\Admin\SideBar;
use App\Rules\OldPassword;
use DateInterval;
use DatePeriod;
use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin\ecom_admin_pages;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Validator;
// use App\Jobs\EmployeesJob;
// use App\Jobs\DepartmentJob;
// use App\Jobs\ZoneJob;
// use App\Jobs\FetchCityApiDataJob;
// use App\Jobs\FetchShiftApiDataJob;

use App\Jobs\Api\FetchEmployeeApiDataJob;
use App\Jobs\Api\FetchDepartmentApiDataJob;
use App\Jobs\Api\FetchZoneApiDataJob;
use App\Jobs\Api\FetchCityApiDataJob;
use App\Jobs\Api\FetchShiftApiDataJob;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Artisan;

class Home extends Controller
{
    public $count;

     // dashboard starts
     public function dashboard()
     {
        // dd(config('livewire.asset_url'));
         //================== testing end ====================================
 
         // Artisan::call('make:command RunComposerInstall');
         // $exitCode = Artisan::call('composer:install');
         // dd('done');
 
         //================== testing end ====================================
 
         // $user = ecom_admin_user::where('id', 166185)->first();
         // return $user->roles->pluck('title');
 
         // $users = ecom_admin_user::all();
 
                 // Create a Faker instance
         // $faker = Faker::create();
         // $AdminUser = new ecom_admin_user();
 
         //         // Fill attributes with random values
         // $AdminUser->employee_id = $faker->unique()->randomNumber(); // Generates a unique random number
         // $AdminUser->email = $faker->unique()->safeEmail(); // Generates a unique safe email address
         // $AdminUser->username = $faker->userName; // Generates a random username
         // $AdminUser->password = bcrypt($faker->password); // Generates a hashed random password
         // $AdminUser->first_name = $faker->firstName; // Generates a random first name
         // $AdminUser->last_name = $faker->lastName; // Generates a random last name
         // $AdminUser->phone = $faker->phoneNumber; // Generates a random phone number
         // $AdminUser->city_id = $faker->numberBetween(1, 100); // Generates a random number between 1 and 100 for city_id
         // $AdminUser->zone_id = $faker->numberBetween(1, 10); // Generates a random number between 1 and 10 for zone_id
         // $AdminUser->role_id = $faker->numberBetween(1, 5); // Generates a random number between 1 and 5 for role_id
         // $AdminUser->department_id = $faker->numberBetween(1, 20); // Generates a random number between 1 and 20 for department_id
         // $AdminUser->sub_department_id = $faker->numberBetween(1, 10); // Generates a random number between 1 and 10 for sub_department_id
         // $AdminUser->time_slot_id = $faker->numberBetween(1, 50); // Generates a random number between 1 and 50 for time_slot_id
         // $AdminUser->device_token = $faker->uuid; // Generates a random UUID for device_token
 
 
         // // Save the user instance
         // $AdminUser->save();
         // $role_ids = [1,2,3];
         
 
         //         // Ensure the user was created successfully
         // if ($AdminUser) {
         //     // Sync roles with the created user
         //     $AdminUser->roles()->sync($role_ids);
         // } else {
         //     // Handle the case where the user was not created
         //     // For example, log an error or throw an exception
         //     throw new Exception('Failed to create user.');
         // }
         // dd('done');
         // dd($users[0]->roles[0]->permissions);
         // $term='';
         // $role=[];
         // $selectRole = Role::where(function ($query) use($term){
         //                                     $query->where('title','like',"%$term%");
         //                                 })
         //                                 ->orderby('id','desc')->limit(10)->get();
 
         // if ($selectRole) 
         // {
         //     foreach ($selectRole as $val) {
         //         $role[] = array('id' => $val->id, 'label' => uppercaseCamelCaseWithSpaces($val->title));
         //     }
         // }
         // dd($role);
 
         
         $Data['onlineUsers'] = ecom_admin_user::online()->where('is_active' , 1)->where('is_deleted', 0)->count();
        //  dd( $onlineUsers);
 
         //================== testing end ====================================
             
         // dd($checkCount);
         // dd($NotificationMessages);
             $Data['usersCount'] = ecom_admin_user::where('is_active' , 1)
                                                    ->where('is_deleted', 0)
                                                        ->count();
            // dd($Data['usersCount']);   //9284 

             // Last week ke users ki count
             $Data['lastWeekUsersCount'] = ecom_admin_user::where('is_active', 1)
                     ->where('is_deleted', 0)
                     ->whereBetween('created_at', [now()->subWeek(), now()])
                     ->count();
 
 
             $Data['instructorCount'] = ecom_admin_user::where('is_active' , 1)
                                            ->where('is_deleted', 0)
                                            ->whereHas('roles', function ($query) {
                                                $query->where('title', 'instructor');
                                            })
                                            ->count();
 
             // Last week ke instructor ki count---------
             $Data['lastWeekinstructorCount'] = ecom_admin_user::where('is_active', 1)
                             ->where('is_deleted', 0)
                             ->whereHas('roles', function ($query) {
                                $query->where('title', 'instructor');
                             })
                             ->whereBetween('created_at', [now()->subWeek(), now()])
                             ->count();
 
             $Data['categoriesCount'] = ecom_category::where('is_active' , 1)
             ->where('is_deleted', 0)
             ->count();
             // Last week ke categories ki count---------
             $Data['lastWeekcategoriesCount'] = ecom_category::where('is_active', 1)
                                 ->where('is_deleted', 0)
                                 ->whereBetween('created_at', [now()->subWeek(), now()])
                                 ->count();
 
             $Data['coursesCount'] = ecom_course::where('is_active' , 1)
             ->where('is_deleted', 0)
             ->count();
 
             // Last week ke course ki count---------
             $Data['lastWeekcourseCount'] = ecom_course::where('is_active', 1)
                         ->where('is_deleted', 0)
                         ->whereBetween('created_at', [now()->subWeek(), now()])
                         ->count();
 
             $Data['departmentsCount'] = ecom_department::where('is_active' , 1)
                         ->count();
 
             // Last week ke departments ki count---------
             $Data['lastWeekdepartmentsCount'] = ecom_department::where('is_active', 1)
                         ->whereBetween('created_at', [now()->subWeek(), now()])
                         ->count();
             return view('dashboard', compact('Data'));
         // return view('dashboard');
     }

     public function Allcities()
     {   
         return view('Admin/listingOnly/City');    
     }
     public function AllZones()    {
         return view('Admin/listingOnly/Zone');
     }
     public function AllShiftimes()    
     {
         return view('Admin/listingOnly/Shift');
     }  
     public function sidebar(Request $request, $id=0)
     {
         $SideBar = new SideBar();
 
 
        if($id != 0)
         {
             $id = base64_decode($request->id);
             $SideBar = $SideBar->find($id);
             return view('Admin.partial.sidebarOperation', compact('SideBar', 'id'));
         }
         else
         {
             return view('Admin.partial.sidebarOperation', compact('id'));
         }
     }
     public function index()
     {
         return redirect()->to('login');
     }
    // ------------------ zone tasks----------------------------
    public function fetchEmployees()
    {
        FetchEmployeeApiDataJob::dispatch();
    }
    public function fetchdepartment()
    {
        FetchDepartmentApiDataJob::dispatch();
    }
    public function fetchzone()
    {
        FetchZoneApiDataJob::dispatch();
    }
    public function fetchcity()
    {
        FetchCityApiDataJob::dispatch();
    }
    public function fetchshift()
    {
        FetchShiftApiDataJob::dispatch();
    }
    public function FetchallHRDATA()
    {   
        // FetchDepartmentApiDataJob::dispatch();  //smooth working
        // FetchZoneApiDataJob::dispatch();        //smooth working
        // FetchCityApiDataJob::dispatch();        //smooth working 
        // FetchShiftApiDataJob::dispatch();          //smooth working 
        // FetchEmployeeApiDataJob::dispatch();
    }

    // ----------------------------------------------
  

    public function changePassword()
    {
        return view('Admin.Auth.change_password');
    }

    public function changePasswordUpdate(Request $request)
    {
        $validate = [
            'current_password' => ['required', new OldPassword],
            'new_password' => ['required'],
            'confirm_password' => ['same:new_password'],
        ];

        $validator = Validator::make($request->all(), $validate);

        if ($validator->passes()) {
            $adminUser = ecom_admin_user::where('id', auth()->user()->id)->update(['password' => bcrypt($request->new_password)]);
            return json_encode(array('status' => 1, 'message' => 'Success'));

        }else{
            $errors = [];
            foreach ($validator->errors()->toArray() as $key => $error_array) {
                foreach ($error_array as $error) {
                    if (!isset($errors[$key])) {
                        $errors[$key] = $error;
                    }
                }
            }
            return json_encode(array('status' => 0, 'errors' => $errors));
        }
    }

   

    public function dashboard_data(Request $request)
    {
        
        $requestData = $request->all();
        if (isset($request->date) && !empty($request->date)) {
            $dates = explode('-', $request->date);
            $startDate = date("Y-m-d", strtotime($dates[0]));
            $endDate = date("Y-m-d", strtotime($dates[1]));
            $requestData['dateFrom'] = $startDate;
            $requestData['dateTo'] = $endDate;
        } else {
            $requestData['dateFrom'] = date("Y-m-d") . " 00:00:00";
            $requestData['dateTo'] = date("Y-m-d") . " 23:59:59";
        }
        $countsData = ecom_booking::dashboardsCounts($requestData);

        return response()->json(['status' => 1, 'data' => $countsData, 'message' => 'success'], 200);
    }

    public function successRateAndRatePerShipment(Request $request)
    {

        if($request->datefrom != '' && $request->dateto){
            $firstDayOfMonth = $request->datefrom;
            $currentDayOfMonth = $request->dateto;
        }else{
            $firstDayOfMonth = date('Y-m-01 00:00:00');
            $currentDayOfMonth = date('Y-m-d 23:59:59');
        }


        $deliveredCount = ecom_booking::forceIndex("booked_packet_date")
            ->whereBetween('created_at', [$firstDayOfMonth, $currentDayOfMonth])
            ->where('booked_packet_status', 12)
            ->whereNot('merchant_id', 557569)
            ->count();
        $totalCount = ecom_booking::forceIndex("booked_packet_date")
            ->whereBetween('created_at', [$firstDayOfMonth, $currentDayOfMonth])
            ->whereNotIn('booked_packet_status', [0, 2])
            ->whereNot('merchant_id', 557569)
            ->where('is_deleted', 0)
            ->count();

        $invoiceIds = ecom_invoice::whereNot('merchant_id', 557569)->whereBetween('invoice_cheque_date', [$firstDayOfMonth, $currentDayOfMonth])->pluck('id')->toArray();

        $invoices = ecom_invoice::whereNot('merchant_id', 557569)->whereBetween('invoice_cheque_date', [$firstDayOfMonth, $currentDayOfMonth])
            ->selectRaw('SUM(invoice_cheque_amount) as total_invoice_cheque_amount')
            ->selectRaw('SUM(total_gst) as total_total_gst')
            ->first();

        $totalInvoiceChequeAmount = $invoices->total_invoice_cheque_amount;
        $totalTotalGst = $invoices->total_total_gst;
        $totalInvoiceAmountWithoutGst = $totalInvoiceChequeAmount - $totalTotalGst;

        $bookingIds = ecom_invoice_booked_packets::whereIn('invoice_id', $invoiceIds)->pluck('booking_id')->toArray();
        $successRateAndRatePerShipment = [
            'total_delivered' => $deliveredCount,
            'total_count' => $totalCount,
            'success_rate' => ($totalCount == 0) ? 0 : round(($deliveredCount/$totalCount) * 100, 2),
            'un_success_rate' => ($totalCount == 0) ? 0 : 100 - round(($deliveredCount/$totalCount) * 100, 2),
            'rate_per_shipment' => (count($bookingIds) == 0) ? 0 : round(($totalInvoiceAmountWithoutGst/count($bookingIds)), 2),
        ];

        return $successRateAndRatePerShipment;
    }

    public function noOfShipment(Request $request)
    {

        if($request->datefrom != '' && $request->dateto){
            $startDate = $request->datefrom;
            $endDate = $request->dateto;
        }else{
            $startDate = date('Y-m-d', strtotime(date('Y-m-d') . '-1 week'));
            $endDate = date('Y-m-d');
        }

        $noOfShipments = ecom_booking::forceIndex("check_date")
            ->select('id',DB::raw("DATE_FORMAT(booked_packet_date, '%d-%b') AS booked_packet_date"),DB::raw('COUNT(*) AS bookings_count'))
            ->whereBetween('booked_packet_date',[$startDate, $endDate])
            ->whereNot('merchant_id', 557569)
            ->groupBy('booked_packet_date')
            ->get()->toArray();

        return response()->json(['status' => 1, 'data' => $noOfShipments, 'message' => 'success'], 200);
    }

    public function firstMileSummary(Request $request)
    {
        if($request->dateFrom != '' && $request->dateTo){
            $startDate = $request->dateFrom;
            $endDate = $request->dateTo;
        }else{
            $startDate = date('Y-m-01 00:00:01');
            $endDate = date('Y-m-d 23:59:59');
        }

        //first mile summary report query
        $summary = ecom_booking::forceIndex("booked_packet_date")
            ->join('ecom_status', 'ecom_bookings.booked_packet_status', '=', 'ecom_status.id')
            ->select(
                'code',
                'destination_city',
                \DB::raw('COUNT(*) AS bookings_count')
            )
            ->whereBetween('ecom_bookings.created_at', [$startDate, $endDate])
            ->whereIn('ecom_bookings.booked_packet_status', [4,14,15,19,20])
            ->whereNot('merchant_id', 557569)
            ->groupBy('ecom_bookings.booked_packet_status')
            ->get()
            ->toArray();

        return response()->json([
            'status' => 1,
            'message' => 'success',
            'result' => $summary,
        ], 200);
    }

    public function reversePickupSummary(Request $request)
    {
        if($request->dateFrom != '' && $request->dateTo){
            $startDate = $request->dateFrom;
            $endDate = $request->dateTo;
        }else{
            $startDate = date('Y-m-01 00:00:00');
            $endDate = date('Y-m-d 23:59:59');
        }


        //reverse pickup summary report query
        $summary = ecom_booking::forceIndex("booked_packet_date")
            ->join('ecom_status', 'ecom_bookings.booked_packet_status', '=', 'ecom_status.id')
            ->select(
                'code',
                'destination_city',
                \DB::raw('COUNT(*) AS bookings_count')
            )
            ->whereBetween('ecom_bookings.created_at', [$startDate, $endDate])
            ->whereNot('merchant_id', 557569)
            ->where('ecom_bookings.vendor_pickup_status', 1)
            ->where('ecom_bookings.is_child', '=', 1)
                //  ->whereIn('ecom_bookings.booked_packet_status', [4,14,15,19,20])
            ->groupBy('ecom_bookings.booked_packet_status')
            ->get()
            ->toArray();

        return response()->json([
            'status' => 1,
            'message' => 'success',
            'result' => $summary,
        ], 200);
    }

    public function summaryReportClientWise(Request $request)
    {
        if($request->date != ''){
            $dates = explode('-', $request->date);
            $startDateTime = new DateTime($dates[0]);
            $endDateTime = new DateTime($dates[1]);
            $startDate = $startDateTime->format("Y-m-d 00:00:00");
            $endDate = $endDateTime->format("Y-m-d 23:59:59");
        }else{
            $startDate = date('Y-m-d');
            $endDate = date('Y-m-d');
        }

        $topTwentyDestinationAndShipmentCounts = ecom_booking::forceIndex("booked_packet_date")
        ->join('ecom_city', 'ecom_bookings.destination_city', '=', 'ecom_city.id')
        ->select(
            'destination_city',
            'city_name',
            \DB::raw('COUNT(*) AS bookings_count')
        )
        ->whereBetween('ecom_bookings.created_at', [$startDate, $endDate])
        ->whereNot('ecom_bookings.merchant_id', 557569);

        if(isset($request->client) && !empty($request->client)){
            $topTwentyDestinationAndShipmentCounts = $topTwentyDestinationAndShipmentCounts->where('ecom_bookings.merchant_id', $request->client);
        }

        $topTwentyDestinationAndShipmentCounts = $topTwentyDestinationAndShipmentCounts
            ->groupBy('ecom_bookings.destination_city')
            ->orderByDesc('bookings_count')
            ->limit(20)
            ->get()
            ->toArray();

        $totalShipmentCounts = 0;
        foreach ($topTwentyDestinationAndShipmentCounts as $shipmentCount) {
            $totalShipmentCounts += $shipmentCount["bookings_count"];
        }

        $totalShipmentZoneWise = ecom_booking::forceIndex("booked_packet_date")
            ->join('central_ops_city', 'ecom_bookings.destination_city', '=', 'central_ops_city.city_id')
            ->select(
                'destination_city',
                'zone',
                \DB::raw('COUNT(*) AS bookings_count')
            )
            ->whereBetween('ecom_bookings.created_at', [$startDate, $endDate])
            ->whereNot('ecom_bookings.merchant_id', 557569);

            if(isset($request->client) && !empty($request->client)){
                $totalShipmentZoneWise = $totalShipmentZoneWise->where('ecom_bookings.merchant_id', $request->client);
            }

        $totalShipmentZoneWise = $totalShipmentZoneWise
            ->groupBy('zone')
            ->orderByDesc('bookings_count')
            ->get()
            ->toArray();

        $totalShipmentZW = 0;
        foreach ($totalShipmentZoneWise as $shipmentCount) {
            $totalShipmentZW += $shipmentCount["bookings_count"];
        }


        $codAmountZoneWise = ecom_booking::forceIndex("booked_packet_date")
        ->join('central_ops_city', 'ecom_bookings.destination_city', '=', 'central_ops_city.city_id')
        ->select(
            'destination_city',
            'zone',
            \DB::raw('SUM(booked_packet_collect_amount) AS cod_amount')
        )
            ->whereBetween('ecom_bookings.created_at', [$startDate, $endDate])
            ->whereNot('ecom_bookings.merchant_id', 557569);


        if(isset($request->client) && !empty($request->client)){
            $codAmountZoneWise = $codAmountZoneWise->where('merchant_id', $request->client);
        }

        $codAmountZoneWise = $codAmountZoneWise->groupBy('zone')
            ->orderByDesc('cod_amount')
            ->get()
            ->toArray();

        $totalCodAmount = 0;
        foreach ($codAmountZoneWise as $codAmount) {
            $totalCodAmount += $codAmount["cod_amount"];
        }

        return response()->json([
            'status' => 1,
            'total_shipment' => $topTwentyDestinationAndShipmentCounts,
            'total_shipment_count' => $totalShipmentCounts,
            'total_shipment_zone_wise' => $totalShipmentZoneWise,
            'total_shipment_zone_wise_count' => $totalShipmentZW,
            'total_cod_amount_zone_wise' => $codAmountZoneWise,
            'total_cod_amount' => number_format($totalCodAmount, 2, '.', ','),
            'message' => 'success'
        ], 200);
    }

    public function weeklySummaryReport(Request $request)
    {

        if($request->date != ''){
            $dates = explode('-', $request->date);
            $startDateTime = new DateTime($dates[0]);
            $endDateTime = new DateTime($dates[1]);
            $startDate = $startDateTime->format("Y-m-d 00:00:00");
            $endDate = $endDateTime->format("Y-m-d 23:59:59");
        }else{
            $endDate = new DateTime();
            $last6Days = [];
            $last6Days[] = $endDate->format('Y-m-d 23:59:59');
            for ($i = 1; $i <= 6; $i++) {
                $last6Days[] = $endDate->sub(new DateInterval('P1D'))->format('Y-m-d 23:59:59');
            }
            $last6Days = array_reverse($last6Days);
            $startDate = $last6Days[0];
            $endDate = $last6Days[6];
        }

        //weekly summary report query
        $summary = ecom_booking::forceIndex("booked_packet_date")
        ->join('central_ops_city', 'ecom_bookings.destination_city', '=', 'central_ops_city.city_id')
            ->select(
                'destination_city',
                'zone',
                \DB::raw('COUNT(*) AS bookings_count')
            )
            ->whereBetween('ecom_bookings.created_at', [$startDate, $endDate])
            ->whereNot('ecom_bookings.merchant_id', 557569)
            ->groupBy('zone')->get()->toArray();

        //delivery ratio query
        $deliveredCount = ecom_booking::forceIndex("booked_packet_date")
            ->whereBetween('created_at', [$startDate, $endDate])
            ->whereNot('merchant_id', 557569)
            ->where('booked_packet_status', 12)
            ->where('is_deleted', 0)
            ->count();


        $totalCount = ecom_booking::forceIndex("booked_packet_date")
            ->whereBetween('created_at', [$startDate, $endDate])
            ->whereNot('merchant_id', 557569)
            ->where('is_deleted', 0)->count();



        return response()->json([
            'status' => 1,
            'summaryReport' => $summary,
            'total_delivered' => $deliveredCount,
            'total_count' => $totalCount,
            'delivery_ratio' => ($totalCount == 0) ? 0 : round(($deliveredCount/$totalCount) * 100, 2),
            'undelivered_ratio' => ($totalCount == 0) ? 0 : 100 - round(($deliveredCount/$totalCount) * 100, 2),
            'message' => 'success'
        ], 200);
    }

    public function topTenDestinationAndOrders(Request $request)
    {
        if($request->date != ''){
            $dates = explode('-', $request->date);
            $startDateTime = new DateTime($dates[0]);
            $endDateTime = new DateTime($dates[1]);
            $startDate = $startDateTime->format("Y-m-d 00:00:00");
            $endDate = $endDateTime->format("Y-m-d 23:59:59");
        }else{
            $startDate = date('Y-m-d 00:00:00');
            $endDate = date('Y-m-d 23:59:59');
        }

        $topDestinationAndOrders = ecom_booking::forceIndex("booked_packet_date")
            ->join('ecom_city', 'ecom_bookings.destination_city', '=', 'ecom_city.id')
            ->select(
                'destination_city',
                'city_name',
                \DB::raw('COUNT(*) AS bookings_count'),
                \DB::raw('SUM(CASE WHEN booked_packet_status = 12 THEN 1 ELSE 0 END) AS delivered_counts')
            )
            ->whereBetween('ecom_bookings.created_at', [$startDate, $endDate])
            ->whereNot('ecom_bookings.merchant_id', 557569)
            ->groupBy('ecom_bookings.destination_city')
            ->orderByDesc('bookings_count')
            ->limit(10)
            ->get()->toArray();

        return response()->json(['status' => 1, 'data' => $topDestinationAndOrders, 'message' => 'success'], 200);

    }

    public function newsFeeds(Request $request)
    {
        $newsFeeds = ecom_news::where('is_active', 1)->where('is_approved', 0)->where('is_deleted', 0)->limit(10)->get()->toArray();
        return response()->json(['status' => 1, 'data' => $newsFeeds, 'message' => 'success'], 200);
    }

//    public function firstMileSummaryCount($cns)
//    {
//
//        $dp_query = DB::connection('oms')->table('book_dispatch')
//            ->select(
//                'STATUS_CODE',
//                'BOOK_DATE',
//                'BOOK_TIME',
//                'CN_NUMBER',
//                \DB::raw('COUNT(*) AS bookings_count')
//            )
//            ->whereIn('STATUS_CODE',['RC','DP'])
//            ->whereIn('CN_NUMBER', $cns)
//            ->orderBy('BOOK_DATE', 'DESC')
//            ->orderBy('BOOK_TIME', 'DESC')
//            ->groupBy('STATUS_CODE')
//            ->get()
//            ->toArray();
//
////        $dp_query = ecom_dispatch_oms::where('STATUS_CODE', '!=', 'CB')
////            ->whereIn('cn_number', $cns)
////            ->orderBy('BOOK_DATE', 'DESC')
////            ->orderBy('BOOK_TIME', 'DESC')
////            ->select('CN_NUMBER','COUR_ID', 'Cour_Name', 'BOOK_DATE', 'BOOK_TIME', 'UNIT_CODE', 'DEST_CITY_ID', 'STATUS_CODE as status');
//
//        $dispatch_list = array();
//
//        if (!empty($dp_query)) {
//
//            foreach ($dp_query as $key=> $row) {
//                $dt = date('Y-m-d H:i:s',strtotime($row->BOOK_DATE . ' ' . $row->BOOK_TIME));
//
////                $kf = array_search($row->status,$status_code);
//
//
//                if (!isset($dispatch_list[$row->STATUS_CODE]['current_date'])) {
//                    $dispatch_list[$row->STATUS_CODE]['current_date'] = $dt;
//                    $dispatch_list[$row->STATUS_CODE]['status_title'] = $row->STATUS_CODE;
//                    $dispatch_list[$row->STATUS_CODE]['booking_count'] = $row->bookings_count;
//
//                } else {
//                    if($dispatch_list[$row->STATUS_CODE]['current_date'] < $dt){
//                        $dispatch_list[$row->STATUS_CODE]['current_date'] = $dt;
//                        $dispatch_list[$row->STATUS_CODE]['status_title'] = $row->STATUS_CODE;
//                        $dispatch_list[$row->STATUS_CODE]['booking_count'] = $row->bookings_count;
//
//                    }else{
//                        $dispatch_list[$row->STATUS_CODE]['current_date'] =   $dispatch_list[$row->STATUS_CODE]['current_date'];
//                        $dispatch_list[$row->STATUS_CODE]['status_title'] =  $dispatch_list[$row->STATUS_CODE]['status_title'];
//                        $dispatch_list[$row->STATUS_CODE]['booking_count'] =  $dispatch_list[$row->STATUS_CODE]['booking_count'];
//                    }
//
//                }
//
//            }
//        }
//
//        $dbRmsCodBookingDropship = DB::connection('lcs_eshipment')->table('rms_cod_booking_dropship')
//            ->select(
//                'Status_code',
//                'created_date',
//                'created_time',
//                'booked_packet_cn',
//                \DB::raw('COUNT(*) AS bookings_count')
//            )
//            ->whereIn('Status_code',['DC','SP'])
//            ->whereIn('booked_packet_cn', $cns)
//            ->orderBy('created_date', 'DESC')
//            ->orderBy('created_time', 'DESC')
//            ->groupBy('Status_code')
//            ->get()
//            ->toArray();
//
//        //Arrival
////        $db_query_ari = ecom_arrival_oms::whereIn('CN_NUMBER', $cns)
////            ->orderBy('ACTIVITY_DATE', 'DESC')
////            ->orderBy('ACTIVITY_TIME', 'DESC')
////            ->select('CN_NUMBER','COURIER_ID', 'Cour_Name', 'ARVL_VIA', 'ARVL_DEST', 'STATUS', 'REASON', 'RECEIVER_NAME', 'ACTIVITY_DATE', 'ACTIVITY_TIME', 'DELIVERY_DATE', 'DELIVERY_TIME');
//
//        // Define $all_stations and $all_statuses here if needed
//
//        if (!empty($dbRmsCodBookingDropship)) {
//            foreach ($dbRmsCodBookingDropship as $key => $row) {
//
//                $dt = date('Y-m-d H:i:s',strtotime($row->created_date . ' ' . $row->created_time));
//
//                if (!isset($dispatch_list[$row->Status_code]['current_date'])) {
//                    $dispatch_list[$row->Status_code]['current_date'] = $dt;
//                    $dispatch_list[$row->Status_code]['status_title'] = $row->Status_code;
//                    $dispatch_list[$row->Status_code]['booking_count'] = $row->bookings_count;
//
//                } else {
//                    if($dispatch_list[$row->Status_code]['current_date'] < $dt){
//                        $dispatch_list[$row->Status_code]['current_date'] = $dt;
//                        $dispatch_list[$row->Status_code]['status_title'] = $row->Status_code;
//                        $dispatch_list[$row->Status_code]['booking_count'] = $row->bookings_count;
//
//                    }else{
//                        $dispatch_list[$row->Status_code]['current_date'] =   $dispatch_list[$row->Status_code]['current_date'];
//                        $dispatch_list[$row->Status_code]['status_title'] =  $dispatch_list[$row->Status_code]['status_title'];
//                        $dispatch_list[$row->Status_code]['booking_count'] =  $dispatch_list[$row->Status_code]['booking_count'];
//                    }
//
//                }
//            }
//        }
//
//        return $dispatch_list;
//    }


}
