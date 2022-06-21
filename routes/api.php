<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use phpDocumentor\Reflection\Types\Resource_;


Route::post('login',    [\App\Http\Controllers\AuthController::class,       'login'])->name('login');


Route::middleware(['auth:api'])->group(function () {

    Route::post('logout',   [\App\Http\Controllers\AuthController::class,       'logout'])->name('logout');
    Route::post('refresh',  [\App\Http\Controllers\AuthController::class,       'refresh'])->name('refresh');
    Route::post('me',       [\App\Http\Controllers\AuthController::class,       'me'])->name('me');

    Route::resource('users', App\Http\Controllers\UsersController::class);

    Route::get('update',    [App\Http\Controllers\ApiTokenController::class,    'update']);
    Route::get('dominios',  [\App\Http\Controllers\UsersController::class,      'dominios']);

});
