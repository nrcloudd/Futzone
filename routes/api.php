<?php
use App\Http\Controllers\LapanganController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\ShowUserController;
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
Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/index', [AuthController::class, 'index']);
    Route::post('/show', [AuthController::class, 'show']);
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
    Route::post('/show', [LapanganController::class, 'show']);
    Route::put('/update/{id}', [LapanganController::class, 'update']); 
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'trans'
], function ($router) {
    Route::post('/index', [TransaksiController::class, 'index']);
    Route::post('/store', [TransaksiController::class, 'store']);
    Route::post('/show', [TransaksiController::class, 'show']);
});

Route::post('/show', [ShowUserController::class, 'show']);
Route::group([
    'middleware' => 'api',
    'prefix' => 'getuser'
], function ($router) {
    Route::post('/show', [ShowUserController::class, 'show']);
});