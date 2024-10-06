<?php

use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\Route;

Route::get('/', [MainController::class, 'index'])->name('home');
Route::post('/', [MainController::class, 'submit'])->name('submit');
Route::get('/game', [MainController::class, 'game'])->name('game');
