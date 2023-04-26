<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\DealController;
use App\Http\Controllers\ZohoTokensController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/grand_token', [ZohoTokensController::class, 'getRefreshToken']);

Route::get('/refresh_token', [ZohoTokensController::class, 'getAccessToken']);

Route::get('/accounts/accountsAndDeals', [AccountController::class, 'accountsAndDeals']);
Route::resource('/accounts', AccountController::class);

Route::resource('/deals', DealController::class);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
