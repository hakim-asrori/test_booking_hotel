<?php

use App\Http\Controllers\API\LoginController;
use App\Http\Controllers\API\RegisterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post("/Register", [RegisterController::class, "register"]);
Route::post("/Login", [LoginController::class, "login"]);
Route::get("/Home", [HomeController::class, "coba_home"]);
Route::get("/Chekin", [ChekinController::class, "coba_chekin"]);
Route::get("/Chekout", [ChekoutController::class, "coba_chekout"]);
Route::get("/Kamar", [KamarController::class, "coba_kamar"]);
Route::get("/Detail_kamar", [LoginController::class, "coba_detail_kamar"]);
Route::get("/Transaksi", [TransaksiController::class, "coba_transaksi"]);






