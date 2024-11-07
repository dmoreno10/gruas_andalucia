<?php

use App\Http\Controllers\AccessLogController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\ConfigurationController;
use App\Http\Controllers\DocumentalGestionController;
use App\Http\Controllers\EmployeesController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\IncidentController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\RateController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\TimeEntryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VehicleController;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\DataTables as DataTablesDataTables;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\PointController;
use App\Http\Controllers\RankingController;
use App\Http\Controllers\TaskController;
use Yajra\DataTables\Facades\DataTables;


Route::auth();

// Ruta para cambiar el idioma de la aplicación
Route::get('lang/{locale}', function (string $locale) {
    if (!in_array($locale, ['en', 'es'])) {
        abort(400);
    }

    // Guardar en sesión
    Session::put('applocale', $locale);
    Log::info('Locale set to: ' . $locale);

    return redirect()->back();
})->name('setLocale');

// Rutas de recuperación de contraseña
Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

// Ruta de inicio
Route::get('/', [HomeController::class, 'index'])->name('home');

// Rutas para login
Route::post('/login', [AdminController::class, 'login']);

// Rutas API sin autenticación
Route::middleware(['api'])->get('/example', function () {
    return response()->json(['message' => 'CORS is working!']);
});

// Rutas para usuarios no autenticados
Route::group(['middleware' => 'guest'], function () {
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
});

// Agrupar las rutas que requieren autenticación
Route::middleware('auth')->group(function () {
    Route::resource('incidents', IncidentController::class);
    Route::resource('accesslogs', AccessLogController::class);
    Route::resource('configuration', ConfigurationController::class);
    Route::resource('files', FileController::class);
    Route::resource('locations', LocationController::class);
    Route::resource('employees', EmployeesController::class);
    Route::resource('reservations', ReservationController::class);
    Route::resource('rates', RateController::class);

    // Rutas relacionadas con usuarios
    Route::get('/users/data', [UserController::class, 'data'])->name('users.data');
    Route::resource('users', UserController::class)->except(['create', 'store']);
    Route::get('/user/download-profile-pdf/{id}', [UserController::class, 'downloadUserProfile'])->name('user.download_profile_pdf');
    Route::get('/profile', [UserController::class, 'profile'])->name('users.profile');
    Route::post('/profile/update-image', [UserController::class, 'updateProfileImage'])->name('users.updateProfileImage');

    // Rutas para vehículos
    Route::resource('vehicles', VehicleController::class);

    // Rutas de puntos y rankings
    Route::apiResource('points', PointController::class);
    Route::resource('rankings', RankingController::class);

    // Rutas de tareas
    Route::resource('tasks', TaskController::class);
    Route::get('tasks/start/{id}', [TaskController::class, 'start'])->name('tasks.start');
    Route::post('/tasks/stop/{id}', [TaskController::class, 'stop'])->name('tasks.stop');
    Route::post('/tasks/cancel/{id}', [TaskController::class, 'cancel'])->name('tasks.cancel');
});

// Rutas relacionadas con entradas de tiempo
Route::resource('time-entries', TimeEntryController::class);
Route::resource('documents-gest', DocumentalGestionController::class);
Route::get('time-entries/get/Data', [TimeEntryController::class, 'getData']);
Route::post('time-entries/start', [TimeEntryController::class, 'start']);
Route::post('time-entries/end', [TimeEntryController::class, 'end']);

// Rutas relacionadas con eventos
Route::resource('events', EventController::class);
Route::get('/events/get/data', [EventController::class, 'getData']);

// Rutas API agrupadas bajo el prefijo 'api' y con autenticación
Route::prefix('api')->middleware('auth:api')->group(function () {
    Route::get('/employees', [EmployeesController::class, 'index']);
    Route::apiResource('points', PointController::class);
    Route::get('/rankings', [RankingController::class, 'index']);
    Route::post('tasks/{id}/complete', [TaskController::class, 'complete'])->name('tasks.complete');
});



