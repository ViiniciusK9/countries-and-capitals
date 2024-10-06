<?php

use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\Route;

Route::get('/', [MainController::class, 'index'])->name('home');
Route::post('/', [MainController::class, 'submit'])->name('submit');
Route::get('/game', [MainController::class, 'game'])->name('game');
Route::get('/answer/{answer}', [MainController::class, 'answer'])->name('answer');
Route::get('/next-question', [MainController::class, 'nextQuestion'])->name('next-question');
Route::get('/show-results', [MainController::class, 'showResults'])->name('show-results');
