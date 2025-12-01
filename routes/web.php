<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/Terima', function () {
    return view('Karyawan/Receiving_page');
});

Route::get('/Stok', function () {
    return view('Karyawan/Stock_page');
});

Route::get('/Musnah', function () {
    return view('Karyawan/Destroy_page');
});

Route::get('/Diskon', function () {
    return view('Karyawan/Discount_page');
});

//contoh route controller
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
