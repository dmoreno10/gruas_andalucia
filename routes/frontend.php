<?php

use App\Http\Controllers\Frontend\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:admin|client'])->controller(UserController::class)->group(function () {
    Route::get('/users/me', 'me')->name('frontend.users.me');
    Route::get('/frontend', 'index')->name('frontend.index');
});