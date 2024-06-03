<?php

use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Route;


Route::get('/', [ContactController::class, 'index']);

Route::resource('contacts', ContactController::class);
