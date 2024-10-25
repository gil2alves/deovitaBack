<?php

use App\Http\Controllers\Admin\MedicoController;
use App\Http\Controllers\Admin\PatientController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Doctor\ConsultationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('jwt.auth',)->group(function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('refresh', [AuthController::class, 'refresh'])->name('refresh');
    Route::post('me', [AuthController::class, 'me'])->name('me');

    Route::apiResource('/doctor', MedicoController::class);
    Route::apiResource('/patient', PatientController::class);
    Route::get('/exams', [MedicoController::class, 'getExams']);
    Route::apiResource('/consultation', ConsultationController::class);
    Route::post('/consultation/start', [ConsultationController::class, 'consultationStart']);
});
Route::post('login', [AuthController::class, 'login'])->name('login');
