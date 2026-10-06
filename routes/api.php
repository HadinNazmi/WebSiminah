<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\DonaturController;
use App\Http\Controllers\API\SumbanganController;
use App\Http\Controllers\API\RedeemController;
use App\Http\Controllers\API\RewardController;
use App\Http\Controllers\API\LokasiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('login', [DonaturController::class, 'login2'])->name('login');
Route::post('register', [DonaturController::class, 'store']);
Route::get('dataLokasi', [LokasiController::class, 'dataLokasi'])->name('dataLokasi');

Route::middleware('auth:sanctum')->group(function(){
    Route::prefix('donaturs')->group(function () {
        Route::get('/{id}', [DonaturController::class, 'show']);
        Route::put('/{id}', [DonaturController::class, 'update']);
    });

    Route::prefix('sumbangans')->group(function () {
        Route::get('/', [SumbanganController::class, 'index']);
        Route::post('/', [SumbanganController::class, 'store']);
		Route::get('all/{id}', [SumbanganController::class, 'show']);
        Route::get('/{id}', [SumbanganController::class, 'showByIdDonatur']);
		Route::get('new/{id}', [SumbanganController::class, 'showLatest']);
		Route::get('home/{id}', [SumbanganController::class, 'show4ByIdDonatur']);
    });

    Route::prefix('redeems')->group(function () {
        Route::get('/', [RedeemController::class, 'index']);
        Route::post('/', [RedeemController::class, 'store']);
        Route::get('/all/{id}', [RedeemController::class, 'show']);
		Route::get('/{id}', [RedeemController::class, 'showByIdDonatur']);
    });

    Route::prefix('rewards')->group(function () {
        Route::get('/', [RewardController::class, 'index']);
        Route::post('/', [RewardController::class, 'store']);
        Route::get('/{id}', [RewardController::class, 'show']);
    });

    Route::prefix('lokasis')->group(function () {
        Route::get('/', [LokasiController::class, 'index']);
        Route::post('/', [LokasiController::class, 'store']);
        Route::get('/{id}', [LokasiController::class, 'show']);
    });
	
	Route::get('cekToken', [DonaturController::class, 'cekToken']);
	Route::post('logout', [DonaturController::class, 'logout']);
});
