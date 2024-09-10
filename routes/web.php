<?php

use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\MerchantController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\Backend\DashboardController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    //logut
    Route::get('/admin/logout', [DashboardController::class, 'adminDestroy'])->name('admin.logout');
    Route::get('/logout', [DashboardController::class, 'adminLogoutPage'])->name('admin.logout.page');


    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/dashboard', [DashboardController::class, 'adminDashboard'])->name('admin.dashboard');
    });

    Route::middleware('role:merchant')->group(function () {
        Route::get('/merchant/dashboard', [DashboardController::class, 'merchantDashboard'])->name('merchant.dashboard');

        Route::resource('merchant', MerchantController::class);
    });

    Route::middleware('role:customer')->group(function () {
        Route::get('/customer/dashboard', [DashboardController::class, 'customerDashboard'])->name('customer.dashboard');
    });
});