<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('login');
});

Route::resource('/employee', \App\Http\Controllers\EmployeeController::class);

Route::resource('/lapangan', \App\Http\Controllers\LapanganController::class);

Route::resource('/transaksi', \App\Http\Controllers\TransaksiController::class);

Route::resource('/member', \App\Http\Controllers\Controller::class);