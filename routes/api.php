<?php 


use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\BatchUpdateController;
use App\Http\Controllers\Admin\ClientUserController;
use App\Http\Controllers\Admin\ConsigneeController;
use App\Http\Controllers\Admin\DataListController;
use App\Http\Controllers\Admin\ManageBookingController;
use App\Http\Controllers\Admin\ManageClientController;
use App\Http\Controllers\Admin\ManageUserController;
use App\Http\Controllers\Admin\MaterialAssignmentController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\TierController;
use App\Http\Controllers\Home;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\ActionController;
use App\Http\Controllers\Admin\ManageLocationController;
use App\Http\Controllers\Admin\ApiController;
use App\Http\Controllers\Admin\ManageController;
use App\Http\Controllers\Admin\MyArrivalController;
use App\Http\Controllers\Status\StatusController;
use App\Http\Controllers\Admin\SupportTicketController;
use App\Http\Controllers\Admin\ManageChequeController;
use App\Http\Controllers\Admin\BankTransactionController;
use App\Http\Controllers\Admin\ReportManagerController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\WebServices;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\DepartmentController;


// ======================= api controllers =========================
use App\Http\Controllers\AdminApis\LectureApiController;
use App\Http\Controllers\AdminApis\AuthenticationController;
use App\Http\Controllers\AdminApis\CourseApiController;

    
//================= Auth APis ==================



//================= lecture Apis ==================

Route::get('/lectures', [LectureApiController::class, 'index']);
Route::post('/lectures', [LectureApiController::class, 'store']);
Route::get('/lectures/{id}', [LectureApiController::class, 'show']);
Route::post('/lectures', [LectureApiController::class, 'store']);
Route::put('/lectures/{id}', [LectureApiController::class, 'update']);
Route::delete('/lectures/{id}', [LectureApiController::class, 'destroy']);


//================= Course Apis ==================

Route::post('/MyCourses', [CourseApiController::class, 'index']);
Route::post('/Lecturelist', [CourseApiController::class, 'Lecturelist']);
Route::post('/LectureViewStatus', [LectureApiController::class, 'LectureViewStatus']);
// Route::post('/Lecturelist', [CourseApiController::class, 'Lecturelist']);

// ======================= api controllers =========================


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
    Route::get('sidebar/{id}',  [Home::class,'sidebar'])->name('sidebar');

// =================== useless at a time ======================
    Route::post('/UpdateLectureAssessmentQuestions', [LectureApiController::class, 'UpdateAssessment'])->name('update.assessment');


    Route::post('/login_api', [ApiController::class, 'login'])->name('login.api');
    Route::post('/set_Api', [ApiController::class, 'SetOTP'])->name('set.otp_api');
    Route::post('/GetOTP', [ApiController::class, 'GetOTP']);

    Route::post('/forgot/password', [AuthController::class, 'forgotPasswordSubmit'])->name('forgot.password');
    Route::get('/get_cities', [DataListController::class, 'getCityForSearch'])->name('get.search.cities');
    Route::get('/get_client_wise_cities', [DataListController::class, 'clientWiseCity'])->name('get.search.client.wise.cities');
    Route::get('/get_states', [DataListController::class, 'getStateForSearch'])->name('get.search.states');
    Route::get('/get_zones', [DataListController::class, 'getZoneForSearch'])->name('get.search.zones');
    Route::get('/get_regions', [DataListController::class, 'getRegionForSearch'])->name('get.search.regions');
    Route::get('/reason', [DataListController::class, 'getReasonForSearch'])->name('get.search.reason');
    Route::get('/get_tier_cities', [DataListController::class, 'getTierCityForSearch'])->name('get.tier.search.cities');
    Route::get('/get_tier', [DataListController::class, 'getTierForSearch'])->name('get.search.tier');
    Route::get('/sales_persons', [DataListController::class, 'getSalesPersonForSearch'])->name('get.sales.person');
    Route::get('get_areas', [DataListController::class, 'getAreas'])->name('get.area');
    Route::get('get_blocks', [DataListController::class, 'getBlocks'])->name('get.block');
    Route::get('/get_countries', [DataListController::class, 'getCountryForSearch'])->name('get.search.countries');
    Route::get('/merchant_list', [DataListController::class, 'getMerchantForSearch'])->name('get.search.merchant');
    Route::get('/merchant_list_parent', [DataListController::class, 'getMerchantForSearchParent'])->name('get.search.merchant.parent');
    Route::get('/material_list', [DataListController::class, 'getMaterialList'])->name('get.search.material');
    Route::get('/clients_list', [DataListController::class, 'getClients']);
    Route::get('/clients_list_parent', [DataListController::class, 'getClientsParent']);
    Route::get('/shippers_list', [DataListController::class, 'getShippers']);
    Route::get('/bank_list', [DataListController::class, 'getBankList'])->name('get.bank.list');
    Route::get('/account_type_list', [DataListController::class, 'getAccountTypeList'])->name('get.account.type.list');
    Route::get('/contact_person', [DataListController::class, 'getContactPerson'])->name('get.contact.person');
    Route::get('/express_centre_list', [DataListController::class, 'getExpressCentreList'])->name('get.express.centre.list');
    Route::get('get_status', [StatusController::class, 'get_status'])->name('get.status');
    Route::get('get_payment_method', [DataListController::class, 'get_payment_method']);
    Route::get('get_payment_status', [DataListController::class, 'get_payment_status']);
    Route::get('role_list', [DataListController::class, 'getRoles'])->name('get.role');
    Route::get('role_list_merchant', [DataListController::class, 'getRolesMerchant'])->name('get.role_merchant');
    Route::get('getShipperRecord', [DataListController::class, 'totalRecordQuery'])->name('get.shipper.record');

    Route::get('get_employee_data', [DataListController::class, 'GetEmployeeData'])->name('get.EmployeeData');
// =================== useless at a time ======================

//================= test ==================

    // Route::get('/testingApi', [DataListController::class, 'TestingApiData'])->name('get.search.cities');

//================= Category ==================

    Route::prefix('category-management')->group(function () 
    {
        Route::prefix('category')->group(function () {
            Route::get('/', [CategoryController::class, 'index'])->name('index');
            Route::get('edit', [CategoryController::class, 'add'])->name('edit'); 
        });
        Route::prefix('sub_category')->group(function () {
            Route::get('/', [CategoryController::class, 'sub_category_index'])->name('index');
            Route::get('edit', [CategoryController::class, 'sub_category_add'])->name('edit'); 
        });
    });

//================= Department ==================

    Route::prefix('department-management')->group(function () 
    {
        Route::prefix('department')->group(function () {
            Route::get('/', [DepartmentController::class, 'index'])->name('index');
            Route::get('edit', [DepartmentController::class, 'add'])->name('edit'); 
        });
        Route::prefix('sub_department')->group(function () {
            Route::get('/', [DepartmentController::class, 'sub_department_index'])->name('index');
            Route::get('edit', [DepartmentController::class, 'sub_department_add'])->name('edit'); 
        });
    });


//================= temp working, need to insert in auth (COURSE) && (COURSE_Align)  ==================

    Route::prefix('content-management')->group(function () 
    {    
        Route::prefix('course')->group(function () {
            Route::get('/', [CourseController::class, 'index'])->name('index');
        });
        Route::prefix('assign_course')->group(function () 
        {
            Route::get('/', [CourseAssignController::class, 'index'])->name('index');
        });
    });

//================= temp working, need to insert in auth (COURSE_Align) ==================



//================= temp working, need to insert in auth==================

Route::middleware('auth:sanctum')->group(function () {



    Route::post('dashboard_data', [Home::class, 'dashboard_data'])->name('dashboard.data');
    Route::post('success_rate_and_rate_per_shipment', [Home::class, 'successRateAndRatePerShipment'])->name('success.rate.per.shipment');
    Route::post('no_of_shipment', [Home::class, 'noOfShipment'])->name('no.of.shipment');
    Route::post('top_ten_destination_and_orders', [Home::class, 'topTenDestinationAndOrders'])->name('top.ten.dest.orders');
    Route::post('summary_report', [Home::class, 'summaryReportClientWise'])->name('summary.report');
    Route::post('weekly_summary_report', [Home::class, 'weeklySummaryReport'])->name('weekly.summary.report');
    Route::post('first_mile_summary', [Home::class, 'firstMileSummary'])->name('first.mile.summary');
    Route::post('reverse_pickup_summary', [Home::class, 'reversePickupSummary'])->name('reverse.pickup.summary');
    Route::post('news_feeds', [Home::class, 'newsFeeds'])->name('news.feeds');

    Route::get('permissions/update', [RoleController::class, 'permissionUpdate'])->name('api.permission.update');
    Route::post('change/password', [Home::class, 'changePasswordUpdate'])->name('merchant.change.password.update');

    Route::prefix('rights')->group(function () {
        Route::prefix('city')->group(function () {
            Route::get('/', [DataListController::class, 'getRightsWiseCity']);
        });
    });

    Route::prefix('manage')->group(function () {
        Route::prefix('pages')->group(function () {
            Route::get('index', [ManageController::class, 'pages_index'])->name('api.pages.index');
            Route::get('edit', [ManageController::class, 'pages_add'])->name('api.pages.edit');
            Route::post('submit', [ManageController::class, 'pages_submit'])->name('api.pages.store');
            Route::post('update', [ManageController::class, 'pages_submit'])->name('api.pages.update');
            Route::get('downloadCsv', [ManageController::class, 'pages_index'])->name('api.pages.download');
            Route::post('status', [ActionController::class, 'status'])->name('api.pages.status');
            Route::post('delete', [ActionController::class, 'destroy'])->name('api.pages.delete');
        });
        Route::prefix('news')->group(function () {
            Route::get('index', [ManageController::class, 'news_index'])->name('api.news.index');
            Route::get('edit', [ManageController::class, 'news_add'])->name('api.news.edit');
            Route::post('submit', [ManageController::class, 'news_submit'])->name('api.news.store');;
            Route::get('downloadCsv', [ManageController::class, 'news_index'])->name('api.news.download');
            Route::post('status', [ActionController::class, 'status'])->name('api.news.status');
            Route::post('delete', [ActionController::class, 'destroy'])->name('api.news.delete');
            Route::post('approve', [ActionController::class, 'approve'])->name('api.news.approve');
        });

        Route::prefix('divisions')->group(function () {
            Route::get('index', [ManageController::class, 'division_index'])->name('api.divisions.index');
            Route::post('status', [ActionController::class, 'status'])->name('api.divisions.status');
            Route::get('downloadCsv', [ManageController::class, 'division_index'])->name('api.divisions.download');
        });

        Route::prefix('services')->group(function () {
            Route::get('index', [ManageController::class, 'services_index'])->name('api.services.index');
            Route::post('status', [ActionController::class, 'status'])->name('api.services.status');
            Route::get('downloadCsv', [ManageController::class, 'services_index'])->name('api.services.download');
        });

        Route::prefix('shipment_type')->group(function () {
            Route::get('index', [ManageController::class, 'shipment_type_index'])->name('api.shipment_type.index');
            Route::get('list', [ManageController::class, 'shipment_type_list'])->name('api.shipment_type.list');
            Route::get('get_services', [ManageController::class, 'get_services'])->name('api.shipment_type.services');
            Route::post('submit', [ManageController::class, 'shipment_type_submit'])->name('api.shipment_type.store');
            Route::get('edit', [ManageController::class, 'shipment_type_add'])->name('api.shipment_type.edit');
            Route::get('downloadCsv', [ManageController::class, 'shipment_type_index'])->name('api.shipment_type.download');
            Route::post('status', [ActionController::class, 'status'])->name('api.shipment_type.status');
            Route::post('delete', [ActionController::class, 'destroy'])->name('api.shipment_type.delete');
        });
        Route::prefix('account_type')->group(function () {
            Route::get('index', [ManageController::class, 'account_type_index'])->name('api.account_type.index');
            Route::post('submit', [ManageController::class, 'account_type_submit'])->name('api.account_type.store');
            Route::get('edit', [ManageController::class, 'account_type_add'])->name('api.account_type.edit');
            Route::get('downloadCsv', [ManageController::class, 'account_type_index'])->name('api.account_type.download');
            Route::post('status', [ActionController::class, 'status'])->name('api.account_type.status');
            Route::post('delete', [ActionController::class, 'destroy'])->name('api.account_type.delete');
        });
        Route::prefix('bank')->group(function () {
            Route::get('index', [ManageController::class, 'bank_index'])->name('api.bank.index');
            Route::post('submit', [ManageController::class, 'bank_submit'])->name('api.bank.store');
            Route::get('edit', [ManageController::class, 'bank_add'])->name('api.bank.edit');
            Route::get('downloadCsv', [ManageController::class, 'bank_index'])->name('api.bank.download');
            Route::post('status', [ActionController::class, 'status'])->name('api.bank.status');
            Route::post('delete', [ActionController::class, 'destroy'])->name('api.bank.delete');
        });
        Route::prefix('booking_type')->group(function () {
            Route::get('index', [ManageController::class, 'booking_type_index'])->name('api.booking_type.index');
            Route::post('submit', [ManageController::class, 'booking_type_submit'])->name('api.booking_type.store');
            Route::get('edit', [ManageController::class, 'booking_type_add'])->name('api.booking_type.edit');
            Route::get('downloadCsv', [ManageController::class, 'booking_type_index'])->name('api.booking_type.download');
            Route::post('status', [ActionController::class, 'status'])->name('api.booking_type.status');
            Route::post('delete', [ActionController::class, 'destroy'])->name('api.booking_type.delete');
        });
        Route::prefix('bank_type')->group(function () {
            Route::get('index', [ManageController::class, 'bank_type_index'])->name('api.bank_type.index');
            Route::get('list', [ManageController::class, 'bank_type_list'])->name('api.bank_type.list');
            Route::post('submit', [ManageController::class, 'bank_type_submit'])->name('api.bank_type.store');
            Route::get('edit', [ManageController::class, 'bank_type_add'])->name('api.bank_type.edit');
            Route::get('downloadCsv', [ManageController::class, 'bank_type_index'])->name('api.bank_type.download');
            Route::post('status', [ActionController::class, 'status'])->name('api.bank_type.status');
            Route::post('delete', [ActionController::class, 'destroy'])->name('api.bank_type.delete');
        });

        Route::prefix('tier')->group(function () {
            Route::get('index', [TierController::class, 'tierIndex'])->name('api.tier.index');
            Route::post('submit', [TierController::class, 'tierSubmit'])->name('api.tier.store');
            Route::get('edit', [TierController::class, 'tierAdd'])->name('api.tier.edit');
            Route::get('downloadCsv', [TierController::class, 'tierIndex'])->name('api.tier.download');
            Route::post('status', [ActionController::class, 'status'])->name('api.tier.status');
            Route::post('delete', [ActionController::class, 'destroy'])->name('api.tier.delete');
        });

    });

    Route::prefix('manage_location')->group(function () {
        Route::prefix('country')->group(function () {
            Route::get('/', [ManageLocationController::class, 'country_index'])->name('index');
            Route::get('list', [ManageLocationController::class, 'country_list']);
            Route::get('edit', [ManageLocationController::class, 'country_add'])->name('edit');
          
            Route::post('update', [ManageLocationController::class, 'country_submit']);
            Route::get('downloadCsv', [ManageLocationController::class, 'country_index']);
            Route::post('status', [ActionController::class, 'status'])->name('status');
            Route::post('delete', [ActionController::class, 'destroy'])->name('delete');
        });
        Route::prefix('state')->group(function () {
            Route::get('/', [ManageLocationController::class, 'state_index'])->name('index');
            Route::get('edit', [ManageLocationController::class, 'state_add'])->name('edit');
            Route::post('submit', [ManageLocationController::class, 'state_submit']);
            Route::post('update', [ManageLocationController::class, 'state_submit']);
            Route::get('downloadCsv', [ManageLocationController::class, 'state_index']);
            Route::post('status', [ActionController::class, 'status'])->name('status')->name('status');
            Route::post('delete', [ActionController::class, 'destroy'])->name('delete')->name('delete');
        });
        Route::prefix('zone')->group(function () {
            Route::get('/', [ManageLocationController::class, 'cod_zone_index'])->name('index');
            Route::get('edit', [ManageLocationController::class, 'cod_zone_add'])->name('edit');
            Route::post('submit', [ManageLocationController::class, 'cod_zone_submit']);
            Route::post('update', [ManageLocationController::class, 'cod_zone_submit']);
            Route::get('downloadCsv', [ManageLocationController::class, 'cod_zone_index']);
            Route::post('status', [ActionController::class, 'status'])->name('status')->name('status');
            Route::post('delete', [ActionController::class, 'destroy'])->name('delete')->name('delete');
        });
        Route::prefix('city')->group(function () {
            Route::get('/', [ManageLocationController::class, 'city_index'])->name('index');
            Route::get('/data_list', [ManageLocationController::class, 'cityDataList'])->name('data.list');
            Route::get('edit', [ManageLocationController::class, 'city_add'])->name('edit');
            Route::post('submit', [ManageLocationController::class, 'city_submit']);
            Route::post('update', [ManageLocationController::class, 'city_submit']);
            Route::get('downloadCsv', [ManageLocationController::class, 'city_index']);
            Route::post('status', [ActionController::class, 'status'])->name('status')->name('status');
            Route::post('delete', [ActionController::class, 'destroy'])->name('delete')->name('delete');
        });
        Route::prefix('express_centre')->group(function () {
            Route::get('/', [ManageLocationController::class, 'expressCentre_index'])->name('index');
            Route::get('edit', [ManageLocationController::class, 'expressCentre_add'])->name('edit');
            Route::post('submit', [ManageLocationController::class, 'expressCentre_submit']);
            Route::post('update', [ManageLocationController::class, 'expressCentre_submit']);
            Route::get('downloadCsv', [ManageLocationController::class, 'expressCentre_index']);
            Route::post('status', [ActionController::class, 'status'])->name('status')->name('status');
            Route::post('delete', [ActionController::class, 'destroy'])->name('delete')->name('delete');
        });
        Route::prefix('cn')->group(function () {
            Route::get('/', [ManageLocationController::class, 'cn_index'])->name('index');
            Route::get('stock', [ManageLocationController::class, 'cn_stock'])->name('cn-stock');
            Route::get('edit', [ManageLocationController::class, 'cn_add'])->name('edit');
            Route::post('submit', [ManageLocationController::class, 'cn_submit']);
            Route::post('update', [ManageLocationController::class, 'cn_submit']);
            Route::get('downloadCsv', [ManageLocationController::class, 'cn_index']);
            Route::post('status', [ManageLocationController::class, 'cn_hold_un_hold'])->name('status');
            Route::get('last_used_cn', [ManageLocationController::class, 'last_used_cn']);
            //            Route::post('delete', [ActionController::class,'destroy'])->name('delete')->name('delete');
        });
    });

    Route::prefix('manage_client')->group(function () {
        Route::get('tariff/dates', [ManageChequeController::class, 'tariffDates'])->name('index');
        Route::prefix('shipper')->group(function () {
            Route::get('/', [ManageClientController::class, 'shipper_index'])->name('index');
            Route::get('edit', [ManageClientController::class, 'shipper_add'])->name('api.admin.merchant.shipper.edit');
            Route::post('submit', [ManageClientController::class, 'shipper_submit']);
            Route::post('update', [ManageClientController::class, 'shipper_submit']);
            Route::get('downloadCsv', [ManageClientController::class, 'shipper_index']);
            Route::post('status', [ActionController::class, 'status'])->name('status');
            Route::post('delete', [ActionController::class, 'destroy'])->name('delete');
            Route::get('get_shippers', [ManageClientController::class, 'get_shippers']);
            Route::get('get_shippersByName', [ManageClientController::class, 'get_shippersByName']);
            Route::get('shipper_details', [ManageClientController::class, 'getShipperDetails']);
            Route::post('delete_bank_details', [ManageClientController::class, 'deleteBanks'])->name('delete.banks');
        });
        Route::prefix('consignee')->group(function () {
            Route::get('/', [ConsigneeController::class, 'consignee_index'])->name('index');
            Route::get('edit', [ConsigneeController::class, 'consignee_add'])->name('api.admin.merchant.consignee.edit');
            Route::post('submit', [ConsigneeController::class, 'consignee_submit']);
            Route::post('update', [ConsigneeController::class, 'consignee_submit']);
            Route::get('downloadCsv', [ConsigneeController::class, 'consignee_index']);
            Route::post('status', [ActionController::class, 'status'])->name('status');
            Route::post('delete', [ActionController::class, 'destroy'])->name('delete');
            Route::get('consignee_details', [ConsigneeController::class, 'getConsigneeDetails']);
        });

        Route::prefix('client')->group(function () {
            Route::get('/', [ClientUserController::class, 'clientUserListing'])->name('client.user.index');
            Route::get('edit', [ClientUserController::class, 'clientUserAdd'])->name('api.admin.client.user.edit');
            Route::post('submit', [ClientUserController::class, 'clientUserSubmit']);
            Route::post('update', [ClientUserController::class, 'clientUserSubmit']);
            Route::get('downloadCsv', [ClientUserController::class, 'clientUserListing']);
            Route::post('status', [ActionController::class, 'status'])->name('status');
            Route::post('delete', [ActionController::class, 'destroy'])->name('delete');
            Route::post('change_password', [ClientUserController::class, 'clientUserChangePasswordPost'])->name('client.user.change.password.post');
        });

        Route::prefix('merchant')->group(function () {
            Route::get('/', [ManageClientController::class, 'company_index'])->name('index');
            Route::get('edit', [ManageClientController::class, 'company_add'])->name('edit');
            Route::get('packing_material', [ManageClientController::class, 'packingMaterial']);
            Route::post('material_rate_update', [ManageClientController::class, 'materialRateUpdate']);
            Route::post('submit', [ManageClientController::class, 'company_submit']);
            Route::post('update', [ManageClientController::class, 'company_submit']);
            Route::get('downloadCsv', [ManageClientController::class, 'company_index']);
            Route::post('status', [ActionController::class, 'status'])->name('status');
            Route::post('delete', [ActionController::class, 'destroy'])->name('delete');
            Route::prefix('request')->group(function () {
                Route::get('/', [ManageClientController::class, 'opening_request'])->name('index');
                Route::get('detail', [ManageClientController::class, 'merchantRequestDetail'])->name('detail');
                Route::get('downloadCsv', [ManageClientController::class, 'opening_request']);
            });
            Route::get('getClientDetail', [ManageClientController::class, 'getClientDetail']);
            Route::get('getPackingMaterial', [ManageClientController::class, 'getPackingMaterial']);
        });
        Route::prefix('user')->group(function () {
            Route::get('/', [ManageClientController::class, 'shipper_index'])->name('index');
            Route::get('edit', [ManageClientController::class, 'shipper_add'])->name('edit');
            Route::post('submit', [ManageClientController::class, 'shipper_submit']);
            Route::post('update', [ManageClientController::class, 'shipper_submit']);
            Route::get('downloadCsv', [ManageClientController::class, 'shipper_index']);
            Route::post('status', [ActionController::class, 'status'])->name('status');
            Route::post('delete', [ActionController::class, 'destroy'])->name('delete');
        });
        Route::prefix('material')->group(function () {
            Route::get('/', [ManageClientController::class, 'material_index'])->name('index');
            Route::get('edit', [ManageClientController::class, 'material_add'])->name('edit');
            Route::post('submit', [ManageClientController::class, 'material_submit']);
            Route::post('update', [ManageClientController::class, 'material_submit']);
            Route::get('downloadCsv', [ManageClientController::class, 'material_index']);
            Route::post('status', [ActionController::class, 'status'])->name('status');
            Route::post('delete', [ActionController::class, 'destroy'])->name('delete');
            Route::prefix('assignment')->group(function () {
                Route::get('/', [MaterialAssignmentController::class, 'index'])->name('index');
                Route::get('edit', [MaterialAssignmentController::class, 'add'])->name('edit');
                Route::post('submit', [MaterialAssignmentController::class, 'submit']);
                Route::post('update', [MaterialAssignmentController::class, 'submit']);
                Route::get('downloadCsv', [MaterialAssignmentController::class, 'index']);
                Route::get('getMaterialData', [MaterialAssignmentController::class, 'getMaterialData']);
                Route::post('status', [ActionController::class, 'status'])->name('status');
                Route::post('delete', [ActionController::class, 'destroy'])->name('delete');
            });
        });
        Route::prefix('batch')->group(function () {
            Route::post('upload', [BatchUpdateController::class, 'batchSubmit'])->name('batch.submit');
            Route::post('update-booked-packet-status', [BatchUpdateController::class, 'updateBookedPacketStatus'])->name('update.booked.packet.status');
        });

        Route::prefix('change_password')->group(function (){
            Route::post('/', [ManageClientController::class, 'changePasswordPost'])->name('change.password');
        });

    });

    Route::prefix('manage_user')->group(function () {
        Route::get('/', [ManageUserController::class, 'userListing'])->name('index');
        Route::get('edit', [ManageUserController::class, 'userAdd'])->name('edit');
        Route::post('submit', [ManageUserController::class, 'userSubmit']);
        Route::post('update', [ManageUserController::class, 'userSubmit']);
        Route::get('city/rights', [ManageUserController::class, 'userRights'])->name('rights');
        Route::post('city/rights', [ManageUserController::class, 'userRightSubmit']);
        Route::get('downloadCsv', [ManageUserController::class, 'userListing']);
        Route::post('status', [ActionController::class, 'status'])->name('status');
        Route::post('delete', [ActionController::class, 'destroy'])->name('delete');
        Route::prefix('roles')->group(function () {
            Route::get('index', [RoleController::class, 'roles_index'])->name('api.roles.index');
            Route::post('submit', [RoleController::class, 'roles_submit'])->name('api.roles.store');
            Route::get('edit', [RoleController::class, 'roles_add'])->name('api.roles.edit');
            Route::get('permission', [RoleController::class, 'setPermission'])->name('api.roles.permission');
            Route::post('permission/submit', [RoleController::class, 'setPermissionsUpdate'])->name('api.roles.permission.submit');
            Route::get('downloadCsv', [RoleController::class, 'roles_index'])->name('api.roles.download');
            Route::post('delete', [ActionController::class, 'destroy'])->name('api.roles.delete');

            Route::prefix('merchant')->group(function () {
                Route::get('index', [RoleController::class, 'roles_merchant_index'])->name('api.roles.merchant.index');
                Route::post('submit', [RoleController::class, 'roles_merchant_submit'])->name('api.roles.merchant.store');
                Route::get('edit', [RoleController::class, 'roles_merchant_add'])->name('api.roles.merchant.edit');
                Route::get('permission', [RoleController::class, 'merchant_setPermission'])->name('api.roles.merchant.permission');
                Route::post('permission/submit', [RoleController::class, 'setPermissionsUpdateMerchant'])->name('api.roles.merchant.permission.submit');
                Route::get('downloadCsv', [RoleController::class, 'roles_merchant_index'])->name('api.roles.merchant.download');
                Route::post('delete', [ActionController::class, 'merchant_destroy'])->name('api.roles.merchant.delete');
            });


        });
    });

    //category  
    // Route::prefix('category-management')->group(function () {
    //     Route::prefix('category')->group(function () {
    //         Route::post('submit', [CategoryController::class, 'submit'])->name('category.submit');
    //     });
    //     Route::prefix('subcategory')->group(function () {
    //         Route::post('submit', [CategoryController::class, 'subcategory_index'])->name('subcategory.index');
    //     });
    // });

    // Route::prefix('report_manager')->group(function () {
    //     Route::prefix('cancel_shipments')->group(function () {
    //         Route::get('/', [ReportManagerController::class, 'cancelShipments']);
    //         Route::get('downloadCsv', [ReportManagerController::class, 'cancelShipments']);
    //     });
    //     Route::prefix('return_shipments')->group(function () {
    //         Route::get('/', [ReportManagerController::class, 'returnShipments']);
    //         Route::get('downloadCsv', [ReportManagerController::class, 'returnShipments']);
    //     });
    //     Route::prefix('pending_shipments')->group(function () {
    //         Route::get('/', [ReportManagerController::class, 'pendingShipments']);
    //         Route::get('downloadCsv', [ReportManagerController::class, 'pendingShipments']);
    //     });
    //     Route::prefix('pending_payments')->group(function () {
    //         Route::get('/', [ReportManagerController::class, 'pendingPayments']);
    //         Route::get('downloadCsv', [ReportManagerController::class, 'pendingPayments']);
    //     });
    //     Route::prefix('received_payments')->group(function () {
    //         Route::get('/', [ReportManagerController::class, 'receivedPayments']);
    //         Route::get('downloadCsv', [ReportManagerController::class, 'receivedPayments']);
    //     });
    //     Route::prefix('invoice_report')->group(function () {
    //         Route::get('/', [ReportManagerController::class, 'invoiceReport']);
    //         Route::get('downloadCsv', [ReportManagerController::class, 'invoiceReport']);
    //     });
    //     Route::prefix('consignment_details')->group(function () {
    //         Route::get('/', [ReportManagerController::class, 'consignmentDetails']);
    //         Route::get('downloadCsv', [ReportManagerController::class, 'consignmentDetails']);
    //     });

    //     Route::prefix('summaryReport')->group(function () {
    //         Route::get('/', [ReportManagerController::class, 'summaryReport']);
    //         Route::get('downloadCsv', [ReportManagerController::class, 'summaryReport']);
    //         Route::post('generate', [ReportManagerController::class, 'generateSummaryReport']);
    //     });

    //     Route::prefix('city_wise_packet_counts')->group(function () {
    //         Route::post('generate', [ReportManagerController::class, 'generatCityWiseReport']);
    //     });

    //     Route::prefix('city_wise_packet_status_counts')->group(function () {
    //         Route::post('generate', [ReportManagerController::class, 'generatCityWiseStatusReport']);
    //     });

    //     Route::prefix('payment_made_client')->group(function () {
    //         Route::get('/', [ReportManagerController::class, 'paymentMadeClient']);
    //         Route::get('downloadCsv', [ReportManagerController::class, 'paymentMadeClient']);
    //     });
    //     Route::prefix('short_payment')->group(function () {
    //         Route::get('/', [ReportManagerController::class, 'shortPayment']);
    //         Route::get('downloadCsv', [ReportManagerController::class, 'shortPayment']);
    //     });
    //     Route::prefix('cheque_issuance')->group(function () {
    //         Route::get('/', [ReportManagerController::class, 'chequeIssuance']);
    //         Route::get('downloadCsv', [ReportManagerController::class, 'chequeIssuance']);
    //     });
    //     Route::prefix('amount_difference')->group(function () {
    //         Route::get('/', [ReportManagerController::class, 'amountDifference']);
    //         Route::get('downloadCsv', [ReportManagerController::class, 'amountDifference']);
    //     });

    //     Route::prefix('sales_summary')->group(function () {
    //         Route::get('/', [ReportManagerController::class, 'saleSummary']);
    //         Route::get('downloadCsv', [ReportManagerController::class, 'saleSummary']);
    //     });

    //     Route::prefix('cn_not_live')->group(function () {
    //         Route::get('/', [ReportManagerController::class, 'cnNotLive']);
    //         Route::get('downloadCsv', [ReportManagerController::class, 'cnNotLive']);
    //     });

    //     Route::prefix('reversal_pickup')->group(function () {
    //         Route::get('/', [ReportManagerController::class, 'reversalPickup']);
    //         Route::get('downloadCsv', [ReportManagerController::class, 'reversalPickup']);
    //     });

    //     Route::prefix('vpc_refund')->group(function () {
    //         Route::get('/', [ReportManagerController::class, 'vpcRefund']);
    //         Route::get('downloadCsv', [ReportManagerController::class, 'vpcRefund']);
    //     });

    //     Route::prefix('negative_balance')->group(function () {
    //         Route::get('/', [ReportManagerController::class, 'negativeBalance']);
    //         Route::get('downloadCsv', [ReportManagerController::class, 'negativeBalance']);
    //     });

    //     Route::prefix('outstanding_balance')->group(function () {
    //         Route::get('/', [ReportManagerController::class, 'outstandingBalance']);
    //         Route::get('downloadCsv', [ReportManagerController::class, 'outstandingBalance']);
    //     });

    //     Route::prefix('retail_cod_details')->group(function () {
    //         Route::get('/', [ReportManagerController::class, 'retailCODDetails']);
    //         Route::get('downloadCsv', [ReportManagerController::class, 'retailCODDetails']);
    //     });

    //     Route::prefix('report_generator')->group(function () {
    //         Route::get('/file/headers', [ReportManagerController::class, 'reportGeneratorFileHeaders']);
    //         Route::post('submit', [ReportManagerController::class, 'reportGeneratorSubmit']);
    //         Route::get('result', [ReportManagerController::class, 'reportGeneratorResult']);
    //         Route::post('result/download', [ReportManagerController::class, 'reportGeneratorResultDownload']);

    //     });

    //     Route::prefix('booking_downloads')->group(function () {
    //         Route::get('/file/headers', [ReportManagerController::class, 'reportGeneratorFileHeaders']);
    //         Route::post('submit', [ReportManagerController::class, 'bookingDownloadSubmit']);
    //         Route::get('result', [ReportManagerController::class, 'reportGeneratorResult']);
    //         Route::post('result/download', [ReportManagerController::class, 'reportGeneratorResultDownload']);
    //     });
    // });

    // Route::prefix('manage_booking')->group(function () {
    //     Route::get('batch_data', [StatusController::class, 'batch_data'])->name('get.batch');
    //     Route::get('list', [ManageBookingController::class, 'Booking_index']); //OK
    //     Route::get('packets/ajax', [ManageBookingController::class, 'ajaxList']); //OK
    //     Route::post('ajaxPage/{num}', [ManageBookingController::class, 'ajaxPage']);
    //     Route::get('downloadCsv', [ManageBookingController::class, 'Booking_index']);
    //     Route::post('downloadCsv', [ManageBookingController::class, 'downloadSelectedColumn']);
    //     Route::get('import_packets', [ManageBookingController::class, 'importPackets']);
    //     Route::post('import/data', [ManageBookingController::class, 'importPacketsData']);
    //     Route::post('UploadPacketData', [ManageBookingController::class, 'UploadPacketData']);
    //     Route::post('add', [ManageBookingController::class, 'packetAdd']); //OK
    //     Route::get('edit', [ManageBookingController::class, 'packetDetails']); //OK
    //     Route::post('loadsheet/process', [ManageBookingController::class, 'loadSheetProcess']); //OK
    //     Route::get('load_sheet', [ManageBookingController::class, 'loadSheet']); //OK
    //     Route::get('bulk_booked_packet_history', [ManageBookingController::class, 'bulkBookedPacketHistory']); //OK
    //     Route::get('download_booking_file/{num}/{num2}', [ManageBookingController::class, 'downloadBookingFile']); //OK
    //     Route::get('cancel_batch/{num}', [ManageBookingController::class, 'cancelBatch']);
    //     Route::get('bulk_print_label', [ManageBookingController::class, 'bulkPrintLabel']); //OK
    //     Route::post('print_multi_label', [ManageBookingController::class, 'multiPrintLabel']); //OK
    //     Route::get('cancel_booked_packet/{any}', [ManageBookingController::class, 'cancelBookedPacket']); //OK
    //     Route::post('update_status', [ManageBookingController::class, 'update_status']);

    //     Route::get('bulk_cancel_booked_packets', [ManageBookingController::class, 'bulkCancelBookedPackets']); //OK

    //     Route::post('csv_cancel_booked_packets', [ManageBookingController::class, 'csvCancelBookedPackets'])->name('upload.cancel.booking.file'); //OK

    //     Route::get('dispatch_report', [ManageBookingController::class, 'dispatchReport']); //OK
    //     Route::get('get_dispatch_data', [ManageBookingController::class, 'getDispatchData']);
    //     Route::post('send_courier_pickup_packetRequest', [ManageBookingController::class, 'send_courier_pickup_packetRequest']);

    //     Route::get('get_shipment_type', [ManageBookingController::class, 'get_shipment_type']); //OK
    //     Route::get('get_services', [ManageBookingController::class, 'get_services']); //OK
    //     Route::get('get_divisions', [ManageBookingController::class, 'get_divisions']); //OK
    //     Route::get('getservicesbydivisions', [ManageBookingController::class, 'get_servicesByDivisions']); //OK
    //     Route::get('getAjaxBookedPacketByCnNumber', [ManageBookingController::class, 'getAjaxBookedPacketByCnNumber']); //OK
    //     //        Route::post('send_courier_pickup_packetRequest', [ManageBookingController::class, 'send_courier_pickup_packetRequest']); //OK
    //     Route::prefix('shipper_advice')->group(function () {
    //         Route::get('/', [ManageBookingController::class, 'shipperAdvice'])->name('index');
    //         Route::get('/log/report', [ManageBookingController::class, 'shipperAdviceLogReport'])->name('log');
    //         Route::get('/log/report/downloadCsv', [ManageBookingController::class, 'shipperAdviceLogReport']);
    //         Route::get('/activity/log', [ManageBookingController::class, 'activityLog']);
    //         Route::get('downloadCsv', [ManageBookingController::class, 'shipperAdvice']);
    //         Route::post('import/process', [ManageBookingController::class, 'importProcess'])->name('import.process');
    //         Route::get('download/sample', [ManageBookingController::class, 'downloadShipperAdviceSampleFile'])->name('download.sample');
    //     });
    //     Route::prefix('my_arrivals')->group(function () {
    //         Route::get('my_arrival_index', [MyArrivalController::class, 'my_arrival_index'])->name('index');
    //         Route::get('downloadCsv', [MyArrivalController::class, 'my_arrival_index']);
    //         Route::get('track_packet', [MyArrivalController::class, 'track_packet']);
    //         Route::get('track_packet_mtech', [MyArrivalController::class, 'track_packet_mtech']);
    //         Route::get('booked_packet_reasons', [MyArrivalController::class, 'booked_packet_reasons']);
    //         Route::post('update_status', [MyArrivalController::class, 'update_status']);

    //         Route::get('my_arrival_mtech', [MyArrivalController::class, 'my_arrival_mtech'])->name('index');
    //         Route::get('downloadCsvOld', [MyArrivalController::class, 'my_arrival_mtech']);
    //     });

    //     Route::get('packet_log', [ManageBookingController::class, 'packet_log'])->name('get.log');
    //     Route::get('airway_bill_log', [ManageBookingController::class, 'airway_bill_log'])->name('get.airway.bill.log');
    // });

    // Route::prefix('support_ticket')->group(function () {
    //     Route::get('/', [SupportTicketController::class, 'supportTicket']);
    //     Route::get('/new', [SupportTicketController::class, 'supportTicketNew']);
    //     Route::get('statistic', [SupportTicketController::class, 'supportTicketStatistic']);
    //     Route::get('add', [SupportTicketController::class, 'supportTicketAdd']);
    //     Route::post('submit', [SupportTicketController::class, 'supportTicketSubmit']);
    //     Route::get('downloadCsv', [SupportTicketController::class, 'supportTicket']);
    //     Route::get('/new/downloadCsv', [SupportTicketController::class, 'supportTicketNew']);
    //     Route::get('view', [SupportTicketController::class, 'supportTicketView'])->name('merchant.api.support_ticket.view');
    //     Route::post('comment_submit', [SupportTicketController::class, 'supportTicketCommentSubmit']);
    //     Route::get('getTrackingHistory', [SupportTicketController::class, 'getTrackingHistory']);
    //     Route::get('getBookingDetail', [SupportTicketController::class, 'getBookingDetail']);
    //     Route::get('images', [SupportTicketController::class, 'getImages']);
    //     Route::get('getIssueType', [SupportTicketController::class, 'getIssueType']);
    //     Route::post('multi_update', [SupportTicketController::class, 'supportTicketMultiUpdate']);
    // });

    // Route::prefix('manage_cheque')->group(function () {
    //     Route::get('/', [ManageChequeController::class, 'index']);
    //     Route::get('add_tariff', [ManageChequeController::class, 'addTariff'])->name('add.tariff');
    //     Route::get('tariff', [ManageChequeController::class, 'viewTariff'])->name('view.tariff');
    //     Route::post('packet/details', [ManageChequeController::class, 'packetsDetailsByClient']);
    //     Route::post('submit', [ManageChequeController::class, 'submit']);
    //     Route::get('print_summary/invoice/{id}', [ManageChequeController::class, 'printSummaryInvoice']);
    //     Route::get('print_detail/invoice/{id}', [ManageChequeController::class, 'printDetailInvoice']);
    //     Route::get('print_summary/invoice/{id}', [ManageChequeController::class, 'printSummaryInvoice']);
    //     Route::get('invoice/summary_multiple/Print', [ManageChequeController::class, 'multipleInvoicePrint']);
    //     Route::get('downloadCsv', [ManageChequeController::class, 'index']);
    //     Route::post('update_payment_status', [ManageChequeController::class, 'updatePaymentStatus']);
    //     Route::get('invoice/{reportType}/{invoiceType}/{id}',  [ManageChequeController::class,'invoice']);
    // });

    // Route::prefix('manage_gst_invoice')->group(function () {
    //     Route::get('/', [ManageChequeController::class, 'gst_invoice']);
    //     Route::get('invoice/{reportType}/{invoiceType}/{id}',  [ManageChequeController::class,'gst_invoice_details']);
    // });

    // Route::prefix('manage_bank_transaction')->group(function () {
    //     Route::get('/', [BankTransactionController::class, 'index']);
    //     Route::get('downloadCsv', [BankTransactionController::class, 'index']);
    //     Route::get('getBookingDetail', [BankTransactionController::class, 'getBookingDetail']);
    //     Route::get('add', [BankTransactionController::class, 'add'])->name('bank_transaction.add');
    //     Route::get('edit', [BankTransactionController::class, 'add'])->name('bank_transaction.edit');
    //     Route::post('submit', [BankTransactionController::class, 'submit']);
    //     Route::get('download/sample', [BankTransactionController::class, 'downloadSampleFile'])->name('download.bank_transaction.sample');
    //     Route::post('import_process', [BankTransactionController::class, 'importProcess']);
    //     Route::get('verify_transaction', [BankTransactionController::class, 'verifyTransaction']);
    //     Route::get('import_history', [BankTransactionController::class, 'importHistory']);
    //     Route::post('delete', [ActionController::class, 'destroy'])->name('delete');
    // });

});
//\Illuminate\Support\Facades\URL::forceScheme('https');

Route::middleware('api_admin_auth')->group(function () {
    Route::post('TrackifyPushBatch/{format?}/{type?}', [WebServices::class, 'TrackifyPushBatch'])->where('type', 'xml|json')->name('api_admin.post.trackify');
});
