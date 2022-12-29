<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\LogoutController;
use App\Http\Controllers\Api\PendaftaranController;

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

/**
 * route "/register"
 * @method "POST"
 */
Route::post('register', RegisterController::class)->name('register');

/**
 * route "/login"
 * @method "POST"
 */
Route::post('login', LoginController::class)->name('login');

/**
 * route "/logout"
 * @method "POST"
 */
Route::post('logout', LogoutController::class)->name('logout');

/**
 * route "/user"
 * @method "GET"
 */
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('pendaftaran', PendaftaranController::class);

Route::get('pdf_formulir_pendaftaran/{NISN}', [PendaftaranController::class, 'downloadPDF']);

Route::patch('pendaftaran/validasi/{pendaftaran}', [PendaftaranController::class, 'updateTervalidasi']);
