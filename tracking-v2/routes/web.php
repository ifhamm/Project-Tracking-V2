<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Dashboard\AdminDashboardController;
use App\Http\Controllers\Dashboard\SuperAdminDashboardController;
use App\Http\Controllers\Dashboard\MechanicDashboardController;
use App\Http\Controllers\Dashboard\InspectorDashboardController;
use App\Http\Controllers\Dashboard\CvdrDashboardController;
use App\Http\Controllers\MwsPartController;
use App\Http\Controllers\MwsStepController;

Route::get('/', function () {
    return view('home');
});

Route::prefix('api')->group(function () {
    Route::post('/mws-parts', [mwsPartController::class, 'store']);
    Route::put('/mws-parts/{id}', [mwsPartController::class, 'update']);
    Route::get('/mws-parts/{id}', [mwsPartController::class, 'show']);
});

Route::get('/mws/create', function () {
    return view('mws_part.create');
})->name('mws.create');

Route::get('/mws', [MwsPartController::class, 'index'])->name('mws.index');
Route::get('/mws/create', function () {
    return view('mws_part.create');
})->name('mws.create');

Route::get('/mws/{id_mws_part}/steps', [MwsStepController::class, 'index'])->name('mws.steps.index');
Route::post('/mws/steps', [MwsStepController::class, 'store'])->name('mws.steps.store');
Route::put('/mws/steps/{id}', [MwsStepController::class, 'update'])->name('mws.steps.update');
Route::delete('/mws/steps/{id}', [MwsStepController::class, 'destroy'])->name('mws.steps.destroy');

Route::get('/mws/{id_mws_part}/steps', [MwsStepController::class, 'index'])->name('mws.steps.index');
Route::post('/mws/steps', [MwsStepController::class, 'store'])->name('mws.steps.store');
Route::put('/mws/steps/{id}', [MwsStepController::class, 'update'])->name('mws.steps.update');
Route::delete('/mws/steps/{id}', [MwsStepController::class, 'destroy'])->name('mws.steps.destroy');


Route::get('/api/get_job_types', [MwsPartController::class, 'getJobTypes']);
Route::post('/mws/store', [MwsPartController::class, 'store'])->name('mws.store');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/superadmin/dashboard', [SuperAdminDashboardController::class, 'index'])->name('superadmin.dashboard');
Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
Route::get('/mechanic/dashboard', [MechanicDashboardController::class, 'index'])->name('mechanic.dashboard');
Route::get('/inspector/dashboard', [InspectorDashboardController::class, 'index'])->name('inspector.dashboard');
Route::get('/cvdr/dashboard', [CvdrDashboardController::class, 'index'])->name('cvdr.dashboard');