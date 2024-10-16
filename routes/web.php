<?php

use App\Http\Controllers\AccessLogController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ConfigurationController;
use App\Http\Controllers\DocumentalGestionController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\IncidentController;
use App\Http\Controllers\UserController;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\App;
use Yajra\DataTables\DataTables as DataTablesDataTables;
use Yajra\DataTables\Facades\DataTables;

Route::auth();

// Ruta de inicio
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/login', [AdminController::class, 'login']);  // Ruta para login

// Agrupar las rutas que requieren autenticación
Route::middleware('auth')->group(function () {
    // Rutas que requieren autenticación
    Route::resource('users', UserController::class);  // Ruta completa para manejar usuarios
    Route::resource('incidents', IncidentController::class);
    Route::resource('accesslogs', AccessLogController::class);
    Route::resource('configuration', ConfigurationController::class);
    Route::resource('documents', DocumentalGestionController::class);
    Route::resource('files', FileController::class);
    // Otras rutas dentro del middleware
    Route::get('/users/data', [UserController::class, 'data'])->name('users.data');
});

// Si necesitas definir rutas fuera del middleware, asegúrate de que no se solapen
Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
// Route::post('/users/store', [UserController::class, 'store'])->name('users.store');


