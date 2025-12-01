<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('Login');
});

Route::get('/home', function () {
    return view('Home');
});

Route::get('/kasir', function () {
    return view('Kasir/Cashier_page');
});

Route::get('/terima', function () {
    return view('Karyawan/Receiving_page');
});

Route::get('/stok', function () {
    return view('Karyawan/Stock_page');
});

Route::get('/musnah', function () {
    return view('Karyawan/Destroy_page');
});

Route::get('/diskon', function () {
    return view('Karyawan/Discount_page');
});

//contoh route controller
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
