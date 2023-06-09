<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/get_token', function () {
    return view('getToken');
});

Route::get('/create_deal', function () {
    return view('createDeal');
});

Route::get('/create_account', function () {
    return view('createAccount');
});

Route::get('/account_list', function () {
    return view('accountList');
});