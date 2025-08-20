<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Alergia\Index;

Route::get('/', function () {
    return view('login');
});


Route::group(['middleware' => ['auth']], function () {
    // Route::get('/', function () {
    //     return view('dashboard');
    // });
});
Route::get('/alergias', Index::class);
Route::get('/dashboard', App\Livewire\Dashboard\Index::class);

