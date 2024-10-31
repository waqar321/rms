<?php 


use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Home;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

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

    Route::post('/login_api', [ApiController::class, 'login'])->name('login.api');
    Route::post('/set_Api', [ApiController::class, 'SetOTP'])->name('set.otp_api');
    Route::post('/GetOTP', [ApiController::class, 'GetOTP']);

    Route::post('/forgot/password', [AuthController::class, 'forgotPasswordSubmit'])->name('forgot.password');
    Route::get('/get_cities', [DataListController::class, 'getCityForSearch'])->name('get.search.cities');
    Route::get('/get_client_wise_cities', [DataListController::class, 'clientWiseCity'])->name('get.search.client.wise.cities');
    Route::get('/get_states', [DataListController::class, 'getStateForSearch'])->name('get.search.states');
    Route::get('/get_zones', [DataListController::class, 'getZoneForSearch'])->name('get.search.zones');
    Route::get('/get_regions', [DataListController::class, 'getRegionForSearch'])->name('get.search.regions');
    Route::get('get_areas', [DataListController::class, 'getAreas'])->name('get.area');
    Route::get('/get_countries', [DataListController::class, 'getCountryForSearch'])->name('get.search.countries');

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




//================= temp working, need to insert in auth==================

Route::middleware('auth:sanctum')->group(function () {



    Route::post('dashboard_data', [Home::class, 'dashboard_data'])->name('dashboard.data');
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
});
//\Illuminate\Support\Facades\URL::forceScheme('https');

Route::middleware('api_admin_auth')->group(function () {
    Route::post('TrackifyPushBatch/{format?}/{type?}', [WebServices::class, 'TrackifyPushBatch'])->where('type', 'xml|json')->name('api_admin.post.trackify');
});
