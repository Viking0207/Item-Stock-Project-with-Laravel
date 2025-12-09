<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\ReceivingController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\CekStokController;
use App\Http\Controllers\DestroyController;
use App\Http\Controllers\AuthController;


Route::get('/', [AuthController::class, 'showLogin'])->name('login.page');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::get('/kasir', function () {
    if (session('role') !== 'kasir') {
        abort(403); // akses ditolak kalau bukan kasir
    }    
    return view('Kasir.Cashier_page');
})->name('Kasir.Cashier_page');    
Route::get('/kasir/cart', [KasirController::class, 'getCart'])->name('kasir.getCart');
Route::post('/kasir/add', [KasirController::class, 'addToCart'])->name('kasir.addToCart');
Route::post('/kasir/checkout', [KasirController::class, 'checkout'])->name('kasir.checkout');
Route::get('/kasir/search', [KasirController::class, 'searchPLU'])->name('kasir.searchPLU');
Route::post('/kasir/submit', [KasirController::class, 'submit']);
Route::get('/kasir/struk/{id}', [KasirController::class, 'struk']);
Route::get('/kasir/check-stock', [KasirController::class, 'checkStock']);


Route::get('/terima', [ReceivingController::class, 'index'])->name('receiving.index');
Route::post('/terima/add', [ReceivingController::class, 'addItem'])->name('receiving.add');
Route::post('/terima/confirm', [ReceivingController::class, 'confirmAll'])->name('receiving.confirm');
Route::delete('/terima/{id}', [ReceivingController::class, 'destroy'])->name('receiving.destroy');
Route::get('/terima/autofill/{plu}', [ReceivingController::class, 'autoFill']);


Route::get('/karyawan', function () {
    // Cek session manual (bisa diganti middleware nanti)
    if (session('role') !== 'karyawan') {
        abort(403); // akses ditolak kalau bukan karyawan
    }    
    return view('Karyawan.MenuKaryawan_page');
})->name('Karyawan.MenuKaryawan_page');    

Route::get('/Stok', function () {
    return view('Karyawan/Stock_page');
});    
Route::get('/cek-stok/{plu}', [CekStokController::class, 'cek']);


Route::get('/destroy', [DestroyController::class, 'index'])->name('destroy.index');
Route::get('/destroy/get-data/{plu}', [DestroyController::class, 'getDataByPLU']);
Route::get('/destroy/get-stock/{plu}', [DestroyController::class, 'getStockByPLU']);
Route::post('/destroy/submit', [DestroyController::class, 'destroy'])->name('destroy.submit');


Route::get('/Diskon', [DiscountController::class, 'index'])
    ->name('discount.page');
Route::get('/api/diskon/{plu}', [DiscountController::class, 'cariBarang']);    





