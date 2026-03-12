<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

//Auth
// Route::get('/login/admin', [AuthController::class, 'adminLoginPage'] );
// Route::get('/login/customer', [AuthController::class, 'customerLoginPage'] );
// Route::post('/login', [AuthController::class, 'login'] );
// Route::post('/logout', [AuthController::class, 'logout'] );
Route::livewire('/login/customer', 'pages::auth.login-customer')->name('login.customer');
Route::livewire('/login/admin', 'pages::auth.login-admin')->name('login.admin');

//Products
// Route::livewire('/admin/products', 'pages::admin.list-products')->name('admin.products');
Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::livewire('/products', 'pages::admin.list-products')
        ->name('list-products');

});

