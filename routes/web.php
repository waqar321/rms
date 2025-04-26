<?php


use App\Http\Controllers\Admin\ManageUserController;

use App\Http\Controllers\Admin\UserManagement\UsersController;
use App\Http\Controllers\Admin\UserManagement\RolesController;
use App\Http\Controllers\Admin\UserManagement\PermissionsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Home;
use App\Http\Controllers\Admin\SettingsController;
// use App\Http\Controllers\Admin\PosController;
use App\Http\Controllers\Admin\ItemController;
use App\Http\Controllers\Admin\ItemCategoryController;
use App\Http\Controllers\Admin\UnitTypeController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\POSController;
use App\Http\Controllers\Admin\VendorController;
use App\Http\Controllers\Admin\LedgerController;
use App\Jobs\CleanCacheAndTempFilesJob;
use App\Models\Admin\ecom_admin_user;
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


// Route::resource('products','ProductController');

Route::group(['middleware' => 'auth'], function () 
{
    Route::resource('notification','NotificationController');
  
    Route::get('dashboard', [Home::class, 'dashboard'])->name('dashboard');
    Route::get('sidebar', [Home::class, 'sidebar'])->name('sidebar');
    Route::get('sidebar/{id}/', [Home::class, 'sidebar'])->name('sidebarEdit');

    Route::get('change-password', [Home::class,'changePassword'])->name('merchant.change.password');

    // Route::get('vendors', [VendorController::class, 'index'])->name('vendors');

    Route::prefix('student')->group(function ()
    {
        // Route::get('/', StudentComponent::class);
        Route::get('/', [StudentController::class, 'index'])->name('index');
        Route::get('edit', [StudentController::class, 'edit'])->name('edit');
    });

    Route::prefix('pos')->group(function () 
    {
        Route::prefix('data-entry-screen/')->group(function () {
            Route::get('/', [PosController::class, 'index'])->name('category.index');
            Route::get('edit', [PosController::class, 'edit'])->name('edit');
            // Route::get('add', [CategoryController::class, 'add'])->name('category.add');
            // Route::get('edit', [CategoryController::class, 'add'])->name('category.edit');
        });
    });
   
    Route::prefix('manage_user')->group(function ()
    {
        // UserManagement
        Route::get('/', [UsersController::class, 'index'])->name('index');
        Route::get('roles', [RolesController::class, 'index'])->name('roles.index');
        Route::get('permissions', [PermissionsController::class, 'index'])->name('permissions.index');
    });

    Route::prefix('item-category')->group(function ()
    {
        // UserManagement
        Route::get('/', [ItemCategoryController::class, 'index'])->name('index');
        Route::get('roles', [ItemCategoryController::class, 'index'])->name('roles.index');
        Route::get('permissions', [ItemCategoryController::class, 'index'])->name('permissions.index');
    });
    Route::prefix('unit-types')->group(function ()
    {
        Route::get('/', [UnitTypeController::class, 'index'])->name('index');
    });
    Route::prefix('items')->group(function ()
    {
        Route::get('/', [ItemController::class, 'index'])->name('index');
        // Route::get('roles', [ItemCategoryController::class, 'index'])->name('roles.index');
        // Route::get('permissions', [ItemCategoryController::class, 'index'])->name('permissions.index');
    });
    Route::prefix('ledgers')->group(function ()
    {
        Route::get('/', [LedgerController::class, 'index'])->name('index');
    });
    // Route::prefix('customers')->group(function ()
    // {
    //     Route::get('/', [CustomerController::class, 'index'])->name('index');
    // });
    Route::prefix('pos')->group(function ()
    {
        Route::get('/', [POSController::class, 'index'])->name('pos.index');
    });
    // Route::prefix('VendorList')->group(function ()
    // {
    //     Route::get('/', [VendorController::class, 'index'])->name('index');
    // });
    Route::get('/print-receipt', function () {
        $cart = session('cart', []);
        // dd($cart);
        return view('print_receipt', compact('cart'));
    })->name('print.receipt');
    
    // Route::prefix('vendors')->group(function ()
    // {
    //     dd('awdawd123');

    //     Route::get('/', [VendorController::class, 'index'])->name('index');
    // });

    Route::prefix('tutorials')->group(function ()
    { 
        Route::get('/', [SettingsController::class, 'tutorials'])->name('tutorials');
    });

});

// \Illuminate\Support\Facades\URL::forceScheme('https');
\Illuminate\Support\Facades\URL::forceScheme('http');
