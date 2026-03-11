<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('welcome');
});

//Auth
Route::get('/login/admin', [AuthController::class, 'adminLoginPage'] );
Route::get('/login/customer', [AuthController::class, 'customerLoginPage'] );
Route::post('/login', [AuthController::class, 'login'] );
Route::post('/logout', [AuthController::class, 'logout'] );

