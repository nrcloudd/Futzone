<?php
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\LapanganController;
use App\Http\Controllers\TipeLapanganController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\cobaController;
use App\Http\Controllers\EditController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\ShowUserController;
use App\Http\Controllers\UpdateProfileController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('/updateprofile', [UpdateProfileController::class, 'update']);
Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/index', [AuthController::class, 'index']);
    Route::post('/show', [AuthController::class, 'show']);
    Route::post('/update', [AuthController::class, 'update']);
    Route::post('/sewa', [AuthController::class, 'sewa']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);  
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'field'
], function ($router) {
    Route::post('/index', [LapanganController::class, 'index']);
    Route::post('/store', [LapanganController::class, 'store']);
    Route::post('/anjay', [LapanganController::class, 'anjay']);
    Route::post('/show', [LapanganController::class, 'show']);
    Route::post('/show2', [LapanganController::class, 'show2']);
    Route::put('/update/{id}', [LapanganController::class, 'update']); 
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'employ'
], function ($router) {
    Route::post('/index', [EmployeeController::class, 'index']);
    Route::post('/store', [EmployeeController::class, 'store']);
    Route::post('/show', [EmployeeController::class, 'show']);
    Route::put('/update/{id}', [EmployeeController::class, 'update']); 
});


Route::group([
    'middleware' => 'api',
    'prefix' => 'trans'
], function ($router) {
    Route::post('/index', [TransaksiController::class, 'index']);
    Route::post('/store', [TransaksiController::class, 'store']);
    Route::post('/anjay', [TransaksiController::class, 'store']);
    Route::post('/show', [TransaksiController::class, 'show']);
    Route::put('/update/{id}', [TransaksiController::class, 'update']); 
});

Route::post('/show', [ShowUserController::class, 'show']);
Route::group([
    'middleware' => 'api',
    'prefix' => 'getuser'
], function ($router) {
    Route::post('/show', [ShowUserController::class, 'show']);
});


Route::group([
    'middleware' => 'api',
    'prefix' => 'tipe'
], function ($router) {
    Route::post('/index', [TipeLapanganController::class, 'index']);
    Route::post('/store', [TipeLapanganController::class, 'store']);
    Route::post('/show', [TipeLapanganController::class, 'show']);
    Route::put('/update/{id}', [TipeLapanganController::class, 'update']); 
});