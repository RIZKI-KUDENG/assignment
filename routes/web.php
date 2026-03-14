<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::livewire('/login/customer', 'pages::auth.login-customer')->name('login.customer');
Route::livewire('/login/admin', 'pages::auth.login-admin')->name('login.admin');

//Admin Routes
Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::livewire('/products', 'pages::admin.list-products')
        ->name('list-products');

    Route::livewire('/products/create', 'pages::admin.create-product')
        ->name('create-product');
        Route::livewire('/transaction', 'pages::admin.list-transactions')->name('list-transactions');

});

//Customer Routes
Route::middleware(['customer'])->prefix('customer')->name('customer.')->group(function (){

    Route::livewire('/transaction', 'pages::customer.list-transactions')->name('list-transactions');
    Route::livewire('transaction/create', 'pages::customer.create-transaction')->name('create-transaction');
});

