<?php

use App\Http\Middleware\CheckAdminRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/users', [CheckAdminRole::class, 'handle'], function (Request $request) {
    // $token = $request->user()->createToken('api-token')->plainTextToken;
    // return ['token' => $token];
    return $request->all();
});
