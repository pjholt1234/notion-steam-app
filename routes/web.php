<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SaleController;
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

Route::controller(DashboardController::class)->group(function () {
    Route::get('/dashboard', 'dashboard')->name('dashboard');
    Route::get('/recalculate', 'recalculate')->name('dashboard.recalculate');
    Route::get('/uploadToNotion', 'uploadToNotion')->name('dashboard.upload');
});


Route::prefix('/purchases')->controller(PurchaseController::class)->group(function () {
    Route::get('/create', 'create')->name('purchases.create');
});

Route::prefix('/sales')->controller(SaleController::class)->group(function () {
    Route::get('/create', 'create')->name('sales.create');
});

