<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CtlAlergiaController;
Route::get('/', function () {
    return view('welcome');
});

Route::resource('alergias', CtlAlergiaController::class);


