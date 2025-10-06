<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('home');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');
// Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/superadmin/dashboard', fn() => 'Superadmin Dashboard')->name('superadmin.dashboard');
Route::get('/admin/dashboard', fn() => 'Admin Dashboard')->name('admin.dashboard');
Route::get('/mechanic/dashboard', fn() => 'Mechanic Dashboard')->name('mechanic.dashboard');
Route::get('/inspector/dashboard', fn() => 'Quality Inspector Dashboard')->name('inspector.dashboard');
Route::get('/cvdr/dashboard', fn() => 'Quality CVDR Dashboard')->name('cvdr.dashboard');