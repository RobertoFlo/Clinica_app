<?php

namespace App\Livewire\Registro;

use Livewire\Component;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class Index extends Component
{

    public $name = '';
    public $email = '';
    public $password = '';
    public $password_confirmation = '';

    public function save()
    {
        $this->dispatch('notify', [
        'variant' => 'info',
        'title' => '¡Usuario creado!',
        'message' => 'El usuario se registró correctamente.'
    ]);
        // $this->validate([
        //     'name' => 'required|string|min:4|max:25|regex:/^[\p{L}]+$/u',
        //     'email' => 'required|string|email|max:150|unique:users',
        //     'password' => 'required|string|min:5|max:25|confirmed|regex:/^[\p{L}\d@#$%&!]+$/u',
        // ]);

        // $user = User::create([
        //     'name' => $this->name,
        //     'email' => $this->email,
        //     'password' => Hash::make($this->password),
        //     'deleted' => Carbon::now()
        // ]);
        // $user->assignRole('usuario');
        // // Redirigir o mostrar un mensaje de éxito
        // //session()->flash('message', 'Usuario registrado exitosamente.');
        // return redirect()->route('login');
    }
    public function messages()
    {
        return [
            'name.required' => 'El nombre de usuario es obligatorio.',
            'name.min' => 'El nombre debe tener al menos :min caracteres.',
            'name.max' => 'El nombre no puede tener más de :max caracteres.',
            'name.regex' => 'El nombre solo puede contener letras, espacios y los caracteres @ # $ % & !.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'El correo electrónico debe ser válido.',
            'email.unique' => 'Este correo ya está registrado.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos :min caracteres.',
            'password.max' => 'La contraseña no puede tener más de :max caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
            'password.regex' => 'El nombre solo puede contener letras,numeros y los caracteres @ # $ % & !.',

        ];
    }
    public function render()
    {
        return view('livewire.registro.index');
    }
}
