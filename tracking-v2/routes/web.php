<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Dashboard\AdminDashboardController;
use App\Http\Controllers\Dashboard\SuperAdminDashboardController;
use App\Http\Controllers\Dashboard\MechanicDashboardController;
use App\Http\Controllers\Dashboard\InspectorDashboardController;
use App\Http\Controllers\Dashboard\CvdrDashboardController;

Route::get('/', function () {
    return view('home');
});

Route::prefix('api')->group(function () {
    Route::post('/mws-parts', [MwsPartController::class, 'store']);
    Route::put('/mws-parts/{id}', [MwsPartController::class, 'update']);
    Route::get('/mws-parts/{id}', [MwsPartController::class, 'show']);
});

Route::get('/mws/create', function () {
    return view('mws_part.create');
})->name('mws.create');

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