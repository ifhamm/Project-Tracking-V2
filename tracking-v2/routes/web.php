<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Dashboard\AdminDashboardController;
use App\Http\Controllers\Dashboard\SuperAdminDashboardController;
use App\Http\Controllers\Dashboard\MechanicDashboardController;
use App\Http\Controllers\Dashboard\InspectorDashboardController;
use App\Http\Controllers\Dashboard\CvdrDashboardController;

Route::get('/', function () {
    return view('home');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/superadmin/dashboard', [SuperAdminDashboardController::class, 'index'])->name('superadmin.dashboard');
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/mechanic/dashboard', [MechanicDashboardController::class, 'index'])->name('mechanic.dashboard');
    Route::get('/inspector/dashboard', [InspectorDashboardController::class, 'index'])->name('inspector.dashboard');
    Route::get('/cvdr/dashboard', [CvdrDashboardController::class, 'index'])->name('cvdr.dashboard');