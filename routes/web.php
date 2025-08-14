<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CtlAlergiaController;
use App\Livewire\Alergia\Index;
Route::get('/', function () {
    return view('login');
});


Route::group(['middleware' => ['auth']], function () {
    // Route::get('/', function () {
    //     return view('dashboard');
    // });
});
// Route::get('alergias', CtlAlergiaController::class);

Route::get('/alergias', Index::class);
