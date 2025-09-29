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
    Route::get('/tipo-examenes', App\Livewire\Tipoexamen\Examen::class);
    Route::get('/tipo-consultas', App\Livewire\TipoConsulta\Consulta::class);
    Route::get('/expediente', App\Livewire\Pasiente\Expediente::class)->name('expediente');
    Route::get('/registro-expediente/{id?}', App\Livewire\Pasiente\Registroexpediente::class)->name('registro.expediente');
    Route::get('/citas', App\Livewire\Cita\Citas::class);
    Route::get('/medicos', App\Livewire\Medicos\Doctores::class);
    Route::get('/usuarios', App\Livewire\Usuario\Users::class);
    Route::get('/clinica', App\Livewire\Clinica\Clinica::class);
    Route::get('/clinica/examenes/{id?}', App\Livewire\Clinica\Examenes::class)->name('clinica.examenes');
    Route::get('/consultas', App\Livewire\Consulta\Consultas::class)->name('consulta');
});

