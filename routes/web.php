<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/users', UserController::class . '@index')->name('users.index');
Route::any('/users/create', UserController::class . '@create')->name('users.create');
Route::post('/users', UserController::class . '@store')->name('users.store');
Route::get('/users/view/{id}', UserController::class . '@view')->name('users.view');

Route::get('/users/export-latest', UserController::class . '@exportCSV')->name('users.export-latest');