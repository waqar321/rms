<?php

use App\Http\Controllers\Admin\BatchUpdateController;
use App\Http\Controllers\Admin\ClientUserController;
use App\Http\Controllers\Admin\ConsigneeController;
use App\Http\Controllers\Admin\ManageBookingController;
use App\Http\Controllers\Admin\ManageClientController;
use App\Http\Controllers\Admin\ManageLocationController;
use App\Http\Controllers\Admin\ManageUserController;

use App\Http\Controllers\Admin\UserManagement\UsersController;
use App\Http\Controllers\Admin\UserManagement\RolesController;
use App\Http\Controllers\Admin\UserManagement\PermissionsController;

use App\Http\Controllers\Admin\MaterialAssignmentController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\TierController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\ManageController;
use App\Http\Controllers\Home;
use App\Http\Controllers\Admin\MyArrivalController;
use App\Http\Controllers\Admin\SupportTicketController;
use App\Http\Controllers\Admin\ManageChequeController;
use App\Http\Controllers\Admin\BankTransactionController;
use App\Http\Controllers\Admin\ReportManagerController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\CourseAssignController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\ProductController;  //testing ck editor
// use App\Http\Controllers\Admin\NotificationController;
// use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\testController;
// use App\Http\Livewire\Admin\Student\StudentComponent;
use App\Jobs\CleanCacheAndTempFilesJob;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [AuthController::class, 'login'])->name('login');
Route::get('/test', [AuthController::class, 'test'])->name('test');

//Route::get('login', [AuthController::class, 'login'])->name('login');
Route::get('/forgot-password', [AuthController::class, 'ForgotPasswordView'])->name('forgot.password');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('phpinfo', function () {
    return phpinfo();
});

Route::get('generalSweepUp', function ()
{
    if(request()->has('ajax'))
    {
        CleanCacheAndTempFilesJob::dispatch();
        return json_encode(['status' => 1, 'message' => 'Cache and temporary files have been cleaned successfully.']);
    }
    else
    {
        CleanCacheAndTempFilesJob::dispatch();
        session()->flash('cache_clear', 'Cache and temporary files have been cleaned successfully.');
        return redirect()->back();
    }
});

Route::get('sweepUp', function ()
{
    // CleanCacheAndTempFiles();
    CleanCacheAndTempFilesJob::dispatch();
    return redirect()->route('dashboard');
});

Route::get('download_log', function () 
{
    $path = storage_path('logs/laravel.log');

    if (file_exists($path)) {
        return response()->download($path);
    } else {
        return response()->json(['error' => 'Log file not found.'], 404);
    }
});

Route::get('testdemo', [testController::class, 'index'])->name('index');
Route::get('testFront', [testController::class, 'testFront'])->name('index');
Route::get('playvideo', [testController::class, 'playvideo'])->name('playvideo');

Route::get('productTesting', [ProductController::class, 'index'])->name('products.index');
// Route::get('ckeditor', [ProductController::class, 'index'])->name('products.index');
// Route::get('ckeditorCreate', [ProductController::class, 'create'])->name('products.create');
// Route::get('ckeditorEdit/{product}', [ProductController::class, 'edit'])->name('products.edit');


Route::get('Allcities', [Home::class, 'Allcities'])->name('Allcities');
Route::get('AllZones', [Home::class, 'AllZones'])->name('AllZones');
Route::get('AllShiftimes', [Home::class, 'AllShiftimes'])->name('AllShiftimes');

//--------------------------- api employees route ----------------

Route::get('/fetch-department', [Home::class, 'fetchdepartment']);   // ok
Route::get('/fetch-zone', [Home::class, 'fetchzone']);               // ok
Route::get('/fetch-city', [Home::class, 'fetchcity']);               // ok 
Route::get('/fetch-shift', [Home::class, 'fetchshift']);             // ok
Route::get('/fetch-employees', [Home::class, 'fetchEmployees']);     // ok 
Route::get('/fetch-allHRDATA', [Home::class, 'FetchallHRDATA']);     // ok 

// Route::resource('products','ProductController');

Route::group(['middleware' => 'auth'], function () 
{
    Route::resource('notification','NotificationController');
    // Route::post('notification/updateDeviceToken', 'NotificationController@updateDeviceToken')->name('notification.updateDeviceToken');
    // Route::post('notification/send-web-notification', 'NotificationController@sendNotification')->name('notification.sendNotification');

    // Route::get('/notification', [NotificationController::class, 'index'])->name('notification.index');
    // Route::post('/store-token', [NotificationController::class, 'updateDeviceToken'])->name('store.token');
    // Route::post('/send-web-notification', [NotificationController::class, 'sendNotification'])->name('send.web-notification');

    Route::get('dashboard', [Home::class, 'dashboard'])->name('dashboard');
    Route::get('sidebar', [Home::class, 'sidebar'])->name('sidebar');
    Route::get('sidebar/{id}/', [Home::class, 'sidebar'])->name('sidebarEdit');

    // Route::prefix('sidebar')->group(function () 
    // {
    //     Route::get('/', [Home::class, 'sidebar'])->name('sidebar');
    //     // Route::get('/lectureView', [Home::class, 'lectureView'])->name('lectureView');
    //     // Route::get('/CourseEnroll', [Home::class, 'CourseEnroll'])->name('CourseEnroll');
    //     // Route::get('/courseView', [CourseController::class, 'courseView'])->name('courseView');
    // });

    Route::get('change-password', [Home::class,'changePassword'])->name('merchant.change.password');

    Route::prefix('manage-department')->group(function () 
    {
        Route::prefix('department')->group(function () 
        {
            Route::get('/', [DepartmentController::class, 'index'])->name('department.index');
            Route::get('edit', [DepartmentController::class, 'edit'])->name('edit');
        });
        Route::prefix('sub_department')->group(function () 
        {
            Route::get('/', [DepartmentController::class, 'sub_department_index'])->name('subdepartment.index');
            Route::get('edit', [DepartmentController::class, 'subDepartmentedit'])->name('edit');
        });
    });

    Route::prefix('student')->group(function ()
    {
        // Route::get('/', StudentComponent::class);
        Route::get('/', [StudentController::class, 'index'])->name('index');
        Route::get('edit', [StudentController::class, 'edit'])->name('edit');
    });

    Route::prefix('category-management')->group(function () 
    {
        Route::prefix('category')->group(function () {
            Route::get('/', [CategoryController::class, 'index'])->name('category.index');
            Route::get('edit', [CategoryController::class, 'edit'])->name('edit');
            // Route::get('add', [CategoryController::class, 'add'])->name('category.add');
            // Route::get('edit', [CategoryController::class, 'add'])->name('category.edit');
        });
        Route::prefix('sub_category')->group(function () {
            Route::get('/', [CategoryController::class, 'sub_category_index'])->name('subcategory.index');
            Route::get('edit', [CategoryController::class, 'SubCategoryedit'])->name('edit');
            // Route::get('add', [CategoryController::class, 'sub_category_add'])->name('category.add');
            // Route::get('edit', [CategoryController::class, 'sub_category_add'])->name('category.edit');
        });
    });

    Route::prefix('manage')->group(function () 
    {
        Route::prefix('pages')->group(function () 
        {
            Route::get('index', [ManageController::class, 'pages_index'])->name('pages.index');
            Route::get('add', [ManageController::class, 'pages_add'])->name('pages.add');
            Route::get('edit', [ManageController::class, 'pages_add'])->name('pages.edit');
        });
        Route::prefix('news')->group(function () {
            Route::get('index', [ManageController::class, 'news_index'])->name('news.index');
            Route::get('add', [ManageController::class, 'news_add'])->name('news.add');
            Route::get('edit', [ManageController::class, 'news_add'])->name('news.edit');
        });
        Route::prefix('divisions')->group(function () {
            Route::get('index', [ManageController::class, 'division_index'])->name('divisions.index');
        });
        Route::prefix('services')->group(function () {
            Route::get('index', [ManageController::class, 'services_index'])->name('services.index');
        });
        Route::prefix('shipment_type')->group(function () {
            Route::get('index', [ManageController::class, 'shipment_type_index'])->name('shipment_type.index');
            Route::get('add', [ManageController::class, 'shipment_type_add'])->name('shipment_type.add');
            Route::get('edit', [ManageController::class, 'shipment_type_add'])->name('shipment_type.edit');
        });
        Route::prefix('account_type')->group(function () {
            Route::get('index', [ManageController::class, 'account_type_index'])->name('account_type.index');
            Route::get('add', [ManageController::class, 'account_type_add'])->name('account_type.add');
            Route::get('edit', [ManageController::class, 'account_type_add'])->name('account_type.edit');
        });
        Route::prefix('bank')->group(function () {
            Route::get('index', [ManageController::class, 'bank_index'])->name('bank.index');
            Route::get('add', [ManageController::class, 'bank_add'])->name('bank.add');
            Route::get('edit', [ManageController::class, 'bank_add'])->name('bank.edit');
        });
        Route::prefix('booking_type')->group(function () {
            Route::get('index', [ManageController::class, 'booking_type_index'])->name('booking_type.index');
            Route::get('add', [ManageController::class, 'booking_type_add'])->name('booking_type.add');
            Route::get('edit', [ManageController::class, 'booking_type_add'])->name('booking_type.edit');
        });
        Route::prefix('bank_type')->group(function () {
            Route::get('index', [ManageController::class, 'bank_type_index'])->name('bank_type.index');
            Route::get('add', [ManageController::class, 'bank_type_add'])->name('bank_type.add');
            Route::get('edit', [ManageController::class, 'bank_type_add'])->name('bank_type.edit');
        });
        Route::prefix('tier')->group(function () {
            Route::get('index', [TierController::class, 'tierIndex'])->name('tier.index');
            Route::get('add', [TierController::class, 'tierAdd'])->name('tier.add');
            Route::get('edit', [TierController::class, 'tierAdd'])->name('tier.edit');
        });

    });

    Route::prefix('content-management')->group(function () 
    {
        Route::prefix('course')->group(function () 
        {
            Route::get('/', [CourseController::class, 'index'])->name('index');
        });
 
        Route::prefix('assign_course')->group(function () 
        {
            Route::get('/', [CourseController::class, 'AlignCourseindex'])->name('index');
        });
        Route::prefix('courseList')->group(function () 
        { 
            Route::get('/', [CourseController::class, 'courseListIndex'])->name('index');
            Route::get('/lectureView', [CourseController::class, 'lectureView'])->name('lectureView');
            Route::get('/CourseEnroll', [CourseController::class, 'CourseEnroll'])->name('CourseEnroll');
            // Route::get('/courseView', [CourseController::class, 'courseView'])->name('courseView');
        });
        Route::prefix('MyCourse')->group(function () 
        {
            Route::get('/', [CourseController::class, 'MyCourse'])->name('MyCourse');
        });
        Route::prefix('LectureUpload')->group(function () 
        {
            Route::get('/', [CourseController::class, 'LectureUploadIndex'])->name('LectureUpload');
        });
        Route::prefix('Lecturelist')->group(function () 
        {
            Route::get('/', [CourseController::class, 'LecturesList'])->name('Lecturelist');
        });
    });

    Route::prefix('manage_location')->group(function (){
        Route::prefix('country')->group(function () {
            Route::get('/', [ManageLocationController::class, 'country_index'])->name('index');
            Route::get('add', [ManageLocationController::class, 'country_add']);
            Route::get('edit', [ManageLocationController::class, 'country_add'])->name('edit');
        });
        Route::prefix('state')->group(function () {
            Route::get('/', [ManageLocationController::class, 'state_index'])->name('index');
            Route::get('add', [ManageLocationController::class, 'state_add']);
            Route::get('edit', [ManageLocationController::class, 'state_add'])->name('edit');
        });
        Route::prefix('zone')->group(function () {
            Route::get('/', [ManageLocationController::class, 'cod_zone_index'])->name('index');
            Route::get('add', [ManageLocationController::class, 'cod_zone_add']);
            Route::get('edit', [ManageLocationController::class, 'cod_zone_add'])->name('edit');
        });
        Route::prefix('city')->group(function () {
            Route::get('/', [ManageLocationController::class, 'city_index'])->name('index');
            Route::get('add', [ManageLocationController::class, 'city_add']);
            Route::get('edit', [ManageLocationController::class, 'city_add'])->name('edit');
        });
        Route::prefix('express_centre')->group(function () {
            Route::get('/', [ManageLocationController::class, 'expressCentre_index'])->name('index');
            Route::get('add', [ManageLocationController::class, 'expressCentre_add']);
            Route::get('edit', [ManageLocationController::class, 'expressCentre_add'])->name('edit');
        });
        Route::prefix('cn')->group(function () {
            Route::get('/', [ManageLocationController::class, 'cn_index'])->name('index');
            Route::get('stock', [ManageLocationController::class, 'cn_stock'])->name('cn-stock');
            Route::get('add', [ManageLocationController::class, 'cn_add']);
            Route::get('edit', [ManageLocationController::class, 'cn_add'])->name('edit');
        });
    });

    Route::prefix('manage_client')->group(function ()
    {
        Route::prefix('shipper')->group(function () {
            Route::get('/', [ManageClientController::class, 'shipper_index'])->name('merchant.shipper.index');
            Route::get('add', [ManageClientController::class, 'shipper_add'])->name('merchant.shipper.add');
            Route::get('edit', [ManageClientController::class, 'shipper_add'])->name('merchant.shipper.edit');
        });
        Route::prefix('consignee')->group(function () {
            Route::get('/', [ConsigneeController::class, 'consignee_index'])->name('merchant.consignee.index');
            Route::get('add', [ConsigneeController::class, 'consignee_add'])->name('merchant.consignee.add');
            Route::get('edit', [ConsigneeController::class, 'consignee_add'])->name('merchant.consignee.edit');
        });
        Route::prefix('merchant')->group(function () {
            Route::get('/', [ManageClientController::class, 'company_index'])->name('index');
            Route::get('add', [ManageClientController::class, 'company_add']);
            Route::get('edit', [ManageClientController::class, 'company_add'])->name('edit');
            Route::get('packing_material', [ManageClientController::class, 'packingMaterial']);
            Route::prefix('request')->group(function () {
                Route::get('/', [ManageClientController::class, 'opening_request']);
                Route::get('/detail', [ManageClientController::class, 'merchantRequestDetail']);
            });
        });

        Route::prefix('client')->group(function () {
            Route::get('/', [ClientUserController::class, 'clientUserListing'])->name('client.user.index');
            Route::get('add', [ClientUserController::class, 'clientUserAdd'])->name('client.user.add');
            Route::get('edit', [ClientUserController::class, 'clientUserAdd'])->name('client.user.edit');
            Route::prefix('password')->group(function (){
                Route::get('/', [ClientUserController::class, 'clientUserChangePassword'])->name('client.user.change.password');
            });
        });

        Route::prefix('batch')->group(function (){
            Route::get('index', [BatchUpdateController::class, 'batchUpload'])->name('batch.upload');
        });

        Route::prefix('material')->group(function () {
            Route::get('/', [ManageClientController::class, 'material_index'])->name('index');
            Route::get('add', [ManageClientController::class, 'material_add']);
            Route::get('edit', [ManageClientController::class, 'material_add'])->name('edit');
            Route::prefix('assignment')->group(function () {
                Route::get('/', [MaterialAssignmentController::class, 'index'])->name('index');
                Route::get('add', [MaterialAssignmentController::class, 'add']);
                Route::get('edit', [MaterialAssignmentController::class, 'add'])->name('edit');
                Route::get('slip', [MaterialAssignmentController::class, 'generateSlipForMaterialAssignment']);
            });
        });

        Route::prefix('password')->group(function (){
            Route::get('/', [ManageClientController::class, 'changePassword'])->name('change.password');
        });

    });

    Route::prefix('manage_user')->group(function ()
    {
        // UserManagement
        Route::get('/', [UsersController::class, 'index'])->name('index');
        Route::get('roles', [RolesController::class, 'index'])->name('roles.index');
        Route::get('permissions', [PermissionsController::class, 'index'])->name('permissions.index');

        // =============== old UserManagement routes =======================
            // Route::get('/', [CourseController::class, 'index'])->name('index');
            // Route::get('edit', [UsersController::class, 'edit'])->name('edit');

            // Route::get('/', [ManageUserController::class, 'userListing'])->name('index');
            // Route::get('add', [ManageUserController::class, 'userAdd']);
            // Route::get('edit', [ManageUserController::class, 'userAdd'])->name('edit');
            // Route::get('rights', [ManageUserController::class, 'userRights'])->name('rights');
            
            // Route::prefix('roles')->group(function () {
                // Route::get('roles', [RolesController::class, 'index'])->name('roles.index');
            //     Route::get('index', [RoleController::class, 'roles_index'])->name('roles.index');
            //     Route::get('add', [RoleController::class, 'roles_add'])->name('roles.add');
            //     Route::get('edit', [RoleController::class, 'roles_add'])->name('roles.edit');
            //     Route::get('permission', [RoleController::class, 'setPermission'])->name('roles.permission');

            //     Route::prefix('merchant')->group(function () {
            //         Route::get('index', [RoleController::class, 'roles_merchant_index'])->name('merchant.roles.index');
            //         Route::get('add', [RoleController::class, 'roles_merchant_add'])->name('merchant.roles.add');
            //         Route::get('edit', [RoleController::class, 'roles_merchant_add'])->name('merchant.roles.edit');
            //         Route::get('permission', [RoleController::class, 'merchant_setPermission'])->name('merchant.roles.permission');
            //     });
            // });
        // ===================================================

    });

    Route::prefix('reports_manager')->group(function (){
        Route::get('cancel_shipment', [ReportManagerController::class, 'cancelShipments']);
        Route::get('return_shipment', [ReportManagerController::class, 'returnShipments']);
        Route::get('pending_shipment', [ReportManagerController::class, 'pendingShipments']);
        Route::get('pending_payments', [ReportManagerController::class, 'pendingPayments']);
        Route::get('received_payments', [ReportManagerController::class, 'receivedPayments']);
        Route::get('invoice_report', [ReportManagerController::class, 'invoiceReport']);
        Route::get('consignment_details', [ReportManagerController::class, 'consignmentDetails']);
        Route::get('summaryReport', [ReportManagerController::class, 'summaryReport']);
        Route::get('payment_made_client', [ReportManagerController::class, 'paymentMadeClient']);
        Route::get('short_payment', [ReportManagerController::class, 'shortPayment']);
        Route::get('cheque_issuance', [ReportManagerController::class, 'chequeIssuance']);
        Route::get('amount_difference', [ReportManagerController::class, 'amountDifference']);
        Route::get('cn_not_live', [ReportManagerController::class, 'cnNotLive']);
        Route::get('reversal_pickup', [ReportManagerController::class, 'reversalPickup']);
        Route::get('vpc_refund', [ReportManagerController::class, 'vpcRefund']);
        Route::get('negative_balance', [ReportManagerController::class, 'negativeBalance']);
        Route::get('outstanding_balance', [ReportManagerController::class, 'outstandingBalance']);
        Route::get('sales_summary', [ReportManagerController::class, 'saleSummary']);
        Route::get('report_generator', [ReportManagerController::class, 'reportGenerator']);
        Route::get('report_generator/result', [ReportManagerController::class, 'reportGeneratorResult']);
        Route::get('retail_cod_details', [ReportManagerController::class, 'retailCODDetails']);
        Route::get('booking_downloads', [ReportManagerController::class, 'bookingDownloads']);
        Route::get('city_wise_packet_counts', [ReportManagerController::class, 'cityWisePackets']);
        Route::get('city_wise_packet_status_counts', [ReportManagerController::class, 'cityWisePacketsStatus']);
    });

    Route::prefix('manage_booking')->group(function (){
        Route::get('list', [ManageBookingController::class, 'Booking_index']); // OK
        Route::get('import_packets', [ManageBookingController::class, 'importPackets']); // OK
        Route::get('create', [ManageBookingController::class, 'bookPacketForm']); // OK
        Route::get('edit', [ManageBookingController::class, 'bookPacketForm']);
        Route::get('edit_vendor_pickup', [ManageBookingController::class, 'bookPacketFormVPC']);
        Route::get('load_sheet', [ManageBookingController::class, 'loadSheet']); // OK
        Route::get('booked_packet_slip/{any}', [ManageBookingController::class, 'bookedPacketSlip']); // OK
        Route::get('print_awb/{any}/merchant/{id}', [ManageBookingController::class, 'printAWB']); // OK
        Route::get('print_performa/{any}/merchant/{id}', [ManageBookingController::class, 'printPerforma']); // OK
        Route::get('export_performa/{any}/merchant/{id}', [ManageBookingController::class, 'exportPerforma']); // OK
        Route::get('bulk_booked_packet_history', [ManageBookingController::class, 'bulkBookedPacketHistory']); //OK
        Route::get('download_booking_file/{num}/{num2}', [ManageBookingController::class, 'downloadBookingFile']); //OK
        Route::get('cancel_batch/{num}', [ManageBookingController::class, 'cancelBatch']);
        Route::get('bulk_print_label', [ManageBookingController::class, 'bulkPrintLabel']); //OK
        Route::post('print_multi_label', [ManageBookingController::class, 'multiPrintLabel']); //OK
        Route::get('cancel_booked_packet/{any}', [ManageBookingController::class, 'cancelBookedPacket']);
        Route::get('bulk_cancel_booked_packets', [ManageBookingController::class, 'bulkCancelBookedPackets'])->name('cancel.bulk.booking');
        Route::post('csv_cancel_booked_packets', [ManageBookingController::class, 'csvCancelBookedPackets']);
        Route::get('dispatch_report', [ManageBookingController::class, 'dispatchReport']);

        Route::prefix('shipper_advice')->group(function () {
            Route::get('/', [ManageBookingController::class, 'shipperAdvice'])->name('index');
            Route::get('import', [ManageBookingController::class, 'import'])->name('import');
            Route::get('/log/report', [ManageBookingController::class, 'shipperAdviceLogReport'])->name('log');
        });
        Route::prefix('my_arrivals')->group(function () {
            Route::get('my_arrival_index', [MyArrivalController::class, 'my_arrival_index'])->name('index');
            Route::get('my_arrival_mtech', [MyArrivalController::class, 'my_arrival_mtech'])->name('index');
        });
    });

    Route::prefix('support_ticket')->group(function () {
        Route::get('/', [SupportTicketController::class, 'supportTicket']);
        Route::get('/new', [SupportTicketController::class, 'supportTicketNew']);
        Route::get('statistic', [SupportTicketController::class, 'supportTicketStatistic']);
        Route::get('add', [SupportTicketController::class, 'supportTicketAdd']);
        Route::post('submit', [SupportTicketController::class, 'supportTicketSubmit']);
        Route::get('downloadCsv', [SupportTicketController::class, 'supportTicket']);
        Route::get('view',  [SupportTicketController::class,'supportTicketView']);
        Route::get('getBookingDetail', [SupportTicketController::class, 'getBookingDetail']);
        Route::get('multi_update', [SupportTicketController::class, 'supportTicketMultiUpdate']);
    });

    Route::prefix('manage_cheque')->group(function () {
        Route::get('/', [ManageChequeController::class, 'index']);
        Route::get('add', [ManageChequeController::class, 'Add']);
        Route::get('tariff', [ManageChequeController::class, 'viewTariff'])->name('view.tariff');
        Route::get('add_tariff', [ManageChequeController::class, 'addTariff'])->name('add.tariff');
        Route::post('submit', [ManageChequeController::class, 'supportTicketSubmit']);
        Route::get('print_summary/invoice/{id}',  [ManageChequeController::class,'printSummaryInvoice']);
        Route::get('print_detail/invoice/{id}',  [ManageChequeController::class,'printDetailInvoice']);
        Route::get('invoice/{reportType}/{invoiceType}/{id}',  [ManageChequeController::class,'invoice']);
    });

    Route::prefix('manage_gst_invoice')->group(function () {
        Route::get('/', [ManageChequeController::class, 'gst_invoice']);
        Route::get('invoice/{reportType}/{invoiceType}/{id}',  [ManageChequeController::class,'gst_invoice_details']);
    });

    Route::prefix('manage_bank_transaction')->group(function () {
        Route::get('/', [BankTransactionController::class, 'index']);
        Route::get('downloadCsv', [BankTransactionController::class, 'index']);
        Route::get('add', [BankTransactionController::class, 'add'])->name('bank_transaction.add');
        Route::get('edit', [BankTransactionController::class, 'add'])->name('bank_transaction.edit');
        Route::get('download/sample', [BankTransactionController::class, 'downloadSampleFile'])->name('download.bank_transaction.sample');
        Route::get('import', [BankTransactionController::class, 'import'])->name('bank_transaction.import');
        Route::post('submit', [BankTransactionController::class, 'submit']);
    });

    Route::prefix('tutorials')->group(function ()
    { 
        Route::get('/', [SettingsController::class, 'tutorials'])->name('tutorials');
    });

});

// \Illuminate\Support\Facades\URL::forceScheme('https');
\Illuminate\Support\Facades\URL::forceScheme('http');
