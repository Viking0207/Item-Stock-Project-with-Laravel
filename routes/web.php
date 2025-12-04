<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReceivingController;
use App\Models\Kategori;
use App\Models\Stock;

Route::get('/', function () {
    return view('Login');
});

Route::get('/Home', function () {
    return view('Home');
});

Route::get('/Kasir', function () {
    return view('Kasir/Cashier_page');
});

Route::get('/Karyawan', function () {
    return view('Karyawan/MenuKaryawan_page');
});

    Route::get('/terima', [ReceivingController::class, 'index'])->name('receiving.index');
    Route::post('/terima', [ReceivingController::class, 'store'])->name('receiving.store');
    Route::delete('/terima/{id}', [ReceivingController::class, 'destroy'])->name('receiving.destroy');


Route::get('/Stok', function () {
    return view('Karyawan/Stock_page');
});

Route::get('/Musnah', function () {
    return view('Karyawan/Destroy_page');
});

Route::get('/Diskon', function () {
    return view('Karyawan/Discount_page');
});
