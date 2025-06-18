<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PasienController;


Route::get('/dashboard', function () {
    return view('dashboard');
});
Route::get('/pasien', [PasienController::class, 'index']);
Route::get('/', function () {
    return view('welcome');
});
