<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\Web\PageController;


Route::get('/', [PageController::class, 'welcome'])->name('welcome');

Route::middleware(['auth:sanctum', config('jetstream.auth_session'),'verified',])
->group(function () {
    Route::get('/dashboard', [PageController::class, 'dashboard'])->name('dashboard');
    Route::get('/chat', [PageController::class, 'chat'])->name('chat');
});
