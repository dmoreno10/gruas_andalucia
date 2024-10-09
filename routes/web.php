<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Support\Facades\Route;



Route::auth();

Route::get('/', [HomeController::class, 'index'])->name('home');
// Route::get('/',function(){return view('admin/');});
// Route::get('/',[AdminController::class,'index'])->name('admin.index')->middleware('auth');
Route::post('/login',[AdminController::class,'login']);

Route::resource('/users', UserController::class);

