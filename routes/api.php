<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\MessageController;


Route::group(['middleware' => ['auth:sanctum']], function(){
    Route::get('users', [UserController::class, 'index'])->name('user.index');
    Route::get('users/me', [UserController::class, 'me'])->name('user.me');
    Route::get('users/{id}', [UserController::class, 'show'])->name('user.show');

    Route::get('messages/{user}', [MessageController::class, 'listMessages'])->name('messages.list');
    Route::post('messages/store', [MessageController::class, 'store'])->name('messages.store');
});


