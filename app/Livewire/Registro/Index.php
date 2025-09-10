<?php

namespace App\Livewire\Registro;

use Livewire\Component;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;

#[Title(content: 'Solicitud de registro')]

class Index extends Component
{
    #[Validate('required|string|min:4|max:25|regex:/^[\p{L}]+$/u')]
    public $name = '';
    #[Validate('required|string|email|max:150|unique:users')]
    public $email = '';
    #[Validate('required|string|min:5|max:25|confirmed|regex:/^[\p{L}\d@#$%&!]+$/u')]
    public $password = '';
    public $password_confirmation = '';

    public function save()
    {
        $this->validate();
        $this->dispatch('show-loader');
        try {
            $user = User::create([
                'name' => $this->name,
                'email' => $this->email,
                'password' => Hash::make($this->password),
                'deleted' => Carbon::now()
            ]);
            $user->assignRole('usuario');
            $this->dispatch('notify', [
                'variant' => 'success',
                'title' => '¡Éxito!',
                'message' => 'Usuario registrado correctamente.'
            ]);
            $this->reset('name', 'email', 'password', 'password_confirmation');
            $this->dispatch(event: 'redirect', data: ['url' => '/login']);
        } catch (\Exception $e) {
            $this->dispatch('notify', [
                'variant' => 'danger',
                'title' => 'Error',
                'message' => 'Hubo un error al registrar el usuario. Inténtalo de nuevo.'
            ]);
        }
    }
    public function messages()
    {
        return [
            'name.required' => 'El nombre de usuario es obligatorio.',
            'name.min' => 'El nombre debe tener al menos 4:min caracteres.',
            'name.max' => 'El nombre no puede tener más de 25:max caracteres.',
            'name.regex' => 'El nombre solo puede contener letras, espacios y los caracteres @ # $ % & !.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'El correo electrónico debe ser válido.',
            'email.unique' => 'Este correo ya está registrado.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos 5:min caracteres.',
            'password.max' => 'La contraseña no puede tener más de 25:max caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
            'password.regex' => 'El nombre solo puede contener letras,numeros y los caracteres @ # $ % & !.',

        ];
    }
    public function render()
    {
        return view('livewire.registro.index');
    }
}