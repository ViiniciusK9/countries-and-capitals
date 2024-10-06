<?php

use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home');

Route::get('/show', [MainController::class, 'index']);
