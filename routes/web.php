<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LokasiController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\RedeemController;
use App\Http\Controllers\RewardController;
use App\Http\Controllers\DonaturController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KontainerController;
use App\Http\Controllers\SumbanganController;


Route::get('/contoh', function () {
    return view('test-component');
});

//Login Admin CSR dan Admin Kelurahan
Route::get('/',[LoginController::class,'index'])->name('login');
Route::post('/ceklogin',[LoginController::class,'ceklogin'])->name('ceklogin');

Route::middleware(['checksession','role:admin_csr,admin_kelurahan'])->group(function() {
    Route::post('/logout',[LoginController::class,'logout'])->name('logout');
    Route::get('/dashboard',[DashboardController::class,'index'])->name('dashboard');
    Route::get('/dashboard/fetchChartData/{lokasiId}', [DashboardController::class,'fetchChartData'])->name('dashboard.fetchChartData/{id}');
    //manajemen lokasi kontainer(csr)
    Route::get('/lokasi',[LokasiController::class,'index'])->name('lokasi');
    Route::get('/lokasi/create',[LokasiController::class,'create'])->name('lokasi.create');
    Route::post('/lokasi',[LokasiController::class,'store'])->name('lokasi.store');
    Route::get('/lokasi/edit/{id}',[LokasiController::class,'edit'])->name('lokasi.edit');
    Route::put('/lokasi/update/{id}',[LokasiController::class,'update'])->name('lokasi.update');
    Route::delete('/lokasi/delete/{id}',[LokasiController::class,'destroy'])->name('lokasi.destroy');
    Route::post('/cek-lokasi', [LokasiController::class,'cekLokasi'])->name('cek-lokasi');

    //kelola data donatur
    Route::get('/donatur',[donaturController::class,'index'])->name('donatur');
    Route::get('/donatur/create',[donaturController::class,'create'])->name('donatur.tambah');
    Route::post('/donatur',[donaturController::class,'store'])->name('donatur.store');
    Route::get('/donatur/{id}',[donaturController::class,'detail'])->name('donatur.getById');
    Route::get('/donatur/edit/{id}',[donaturController::class,'edit'])->name('donatur.edit');
    Route::put('/donatur/update/{id}',[donaturController::class,'update'])->name('donatur.update');
    
    //verifikasi sumbangan
    Route::get('/sumbangan', [SumbanganController::class,'index'])->name('sumbangan');
    Route::get('/sumbangan/detail', [SumbanganController::class,'detail'])->name('sumbangan.detail');
    Route::post('/sumbangan/edit/{id}/{created_at}', [SumbanganController::class, 'edit'])->name('sumbangan.edit');
    Route::put('/sumbangan/update/{id}/{created_at}',[SumbanganController::class,'update'])->name('sumbangan.update');
    
    //manajemen kontainer kelurahan
    Route::get('/kontainer',[KontainerController::class,'index'])->name('kontainer');
    Route::get('/kontainer/create',[KontainerController::class,'create'])->name('kontainer.create');
    Route::post('/kontainer',[KontainerController::class,'store'])->name('kontainer.store');
    Route::get('/kontainer/edit/{id}',[KontainerController::class,'edit'])->name('kontainer.edit');
    Route::put('/kontainer/update/{id}',[KontainerController::class,'update'])->name('kontainer.update');
    Route::delete('/kontainer/delete/{id}',[KontainerController::class,'destroy'])->name('kontainer.destroy');
    Route::put('/kontainer/update-permintaan/{id}',[KontainerController::class,'updatePermintaan'])->name('kontainer.updatePermintaan');
    Route::post('/kontainer/storePermintaan/{id_kontainer}',[KontainerController::class,'storePermintaan'])->name('kontainer.storePermintaan');
    Route::get('/kontainer/isPermintaanDiajukan/{id_kontainer}',[KontainerController::class,'isPermintaanDiajukan'])->name('kontainer.isPermintaanDiajukan');
            
    //manajemen redeem (adm-kelurahan)
    Route::get('/hadiah',[RewardController::class,'index'])->name('hadiah');
    Route::get('/redeem',[RedeemController::class,'index'])->name('redeem');
    Route::get('/redeem/detail',[RedeemController::class,'detail'])->name('redeem.detail');
    Route::post('/redeem/{id}',[RedeemController::class,'update'])->name('redeem.update');
    
    //profil admin
    Route::get('/profil',[ProfilController::class,'index'])->name('profil');
    Route::get('/profil/edit',[ProfilController::class,'edit'])->name('profil.edit');
    Route::post('/profil/{id}',[ProfilController::class,'update'])->name('profil.update');

    Route::get('/404', function () {
        return view('errors.404');
    });
    
});

Route::middleware(['checksession','role:admin_csr'])->group(function() {
    //manajemen admin kelurahan(csr)
    Route::get('/admin-kelurahan',[AdminController::class,'index'])->name('admin');
    Route::get('/admin-kelurahan/create',[AdminController::class,'create'])->name('admin.create');
    Route::post('/admin-kelurahan',[AdminController::class,'store'])->name('admin.store');
    Route::get('/admin-kelurahan/edit/{id}',[AdminController::class,'edit'])->name('admin.edit');
    Route::put('/admin-kelurahan/update/{id}',[AdminController::class,'update'])->name('admin.update');
    Route::put('/admin-kelurahan/reset/{id}',[AdminController::class,'resetPassword'])->name('admin.reset');
    Route::delete('/admin-kelurahan/delete/{id}',[AdminController::class,'destroy'])->name('admin.destroy');
    Route::get('/admin-kelurahan/lokasi/{id}', [AdminController::class, 'cek_kelurahan'])->name('admin.ceklokasi');
    
    //manajemen hadiah
    Route::post('/hadiah',[RewardController::class,'store'])->name('hadiah.store');
    Route::put('/hadiah/{id}',[RewardController::class,'update'])->name('hadiah.update');
    Route::delete('/hadiah/{id}',[RewardController::class,'destroy'])->name('hadiah.delete');
    
    //ajax sumbangan
    Route::get('/sumbangan/filter',[SumbanganController::class,'filterData'])->name('sumbangans');

    
    Route::delete('/donatur/delete/{id}',[DonaturController::class,'destroy'])->name('donatur.destroy');
    
});