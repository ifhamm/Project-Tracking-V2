<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MwsPartController;

Route::get('/', function () {
    return view('welcome');
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
