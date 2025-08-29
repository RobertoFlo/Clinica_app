<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Alergia\Index;

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('inicio-session', [App\Http\Controllers\LoginController::class, 'login'])->name('inicio.session');
Route::get('register',App\Livewire\Registro\Index::class)->name('Register');
Route::post('logout', [App\Http\Controllers\LoginController::class, 'logout'])->name('cierrar.session');
Route::group(['middleware' => ['auth']], function () {
    Route::get('/', App\Livewire\Dashboard\Index::class);
    Route::get('/alergias', Index::class);
});

