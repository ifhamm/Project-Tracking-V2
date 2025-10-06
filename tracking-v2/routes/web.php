<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MwsPartController;
use Illuminate\Support\Facades\Route;

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
// Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/superadmin/dashboard', fn() => 'Superadmin Dashboard')->name('superadmin.dashboard');
Route::get('/admin/dashboard', fn() => 'Admin Dashboard')->name('admin.dashboard');
Route::get('/mechanic/dashboard', fn() => 'Mechanic Dashboard')->name('mechanic.dashboard');
Route::get('/inspector/dashboard', fn() => 'Quality Inspector Dashboard')->name('inspector.dashboard');
Route::get('/cvdr/dashboard', fn() => 'Quality CVDR Dashboard')->name('cvdr.dashboard');