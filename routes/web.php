<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/trajets', [HomeController::class, 'trajets'])->name('trajets.index');
Route::get('/trajets/{trajet}', [HomeController::class, 'trajet'])->name('trajets.show');
