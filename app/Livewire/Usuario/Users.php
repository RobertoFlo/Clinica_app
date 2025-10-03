<?php

namespace App\Livewire\Usuario;

use App\Models\Medicos;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Title;
use Carbon\Carbon;
use Livewire\Attributes\On;
use Livewire\WithPagination;

use function Pest\Laravel\delete;

#[Title(content: 'Gestión de usuarios')]
class Users extends Component
{
    use WithPagination;
    public $name = '';
    public $email = '';
    public $password = '';
    public $password_confirmation = '';
    public $medicos = [];
    public $showModal = false;
    public $rol_seleccionado = '';
    public $user_seleccionado = [];
    public $medico_seleccionado = '';
    public $texto_modal = '';
    public $showModalDELETE = false;
    public function modalOpen()
    {
        $this->showModal = true;
    }
    public function modalClose()
    {
        $this->reset(['name', 'email', 'password', 'password_confirmation', 'rol_seleccionado']);
        $this->showModal = false;
    }
    public function rules()
    {
        if ($this->user_seleccionado) {
            $userId = $this->user_seleccionado['id'];
            return [
                'rol_seleccionado' => 'required',
                'name' => 'required|string|min:4|max:25|regex:/^[\p{L}]+$/u',
                'email' => "required|string|email|max:150|unique:users,email,{$userId}",
                'password' => 'nullable|string|min:5|max:25|confirmed|regex:/^[\p{L}\d@#$%&!]+$/u',
            ];
        } else {
            return [
                'rol_seleccionado' => 'required',
                'name' => 'required|string|min:4|max:25|regex:/^[\p{L}]+$/u',
                'email' => 'required|string|email|max:150|unique:users,email',
                'password' => 'required|string|min:5|max:25|confirmed|regex:/^[\p{L}\d@#$%&!]+$/u',
            ];
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
            'email.max' => 'El correo electrónico no puede tener más de 150:max caracteres.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos 5:min caracteres.',
            'password.max' => 'La contraseña no puede tener más de 25:max caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
            'password.regex' => 'La contraseña solo puede contener letras, números y los caracteres @ # $ % & !.',
            'rol_seleccionado.required' => 'El rol es obligatorio.',
        ];
    }
    #[On('item_tabla')]
    public function seleccion_medico($itemId, $accion)
    {
        switch ($accion) {
            case 'editar':
                $this->user_seleccionado = User::withTrashed()->find($itemId);
                $this->name = $this->user_seleccionado['name'];
                $this->email = $this->user_seleccionado['email'];
                $this->rol_seleccionado = $this->user_seleccionado['roles']->pluck('name')->first();
                $medico = Medicos::where('usuario_id', $this->user_seleccionado['id'])->first();
                $this->medico_seleccionado = $medico ? $medico['id'] : '';
                $this->showModal = true;
                break;
            case 'eliminar':
                $this->user_seleccionado = User::withTrashed()->find($itemId);
                if ($this->user_seleccionado['deleted_at']) {
                    $this->texto_modal = '¿Estás seguro de que deseas restaurar este usuario?';
                    $this->showModalDELETE = true;
                } else {
                    $this->texto_modal = '¿Estás seguro de que deseas eliminar este usuario?';
                    $this->showModalDELETE = true;
                }
                break;
            default:
                $this->dispatch('notify', [
                    'variant' => 'error',
                    'title' => 'Error',
                    'message' => 'Acción no reconocida.'
                ]);
                break;
        }
    }
    public function closeModalDELETE()
    {
        $this->reset(['user_seleccionado']);
        $this->showModalDELETE = false;
    }
    public function eliminar()
    {
        $this->dispatch('show-loader');
        $usuario = User::withTrashed()->find($this->user_seleccionado['id']);
        if (!$usuario->deleted_at) {
            $usuario->delete();
            $this->dispatch('notify', [
                'variant' => 'success',
                'title' => '¡Éxito!',
                'message' => 'Usuario eliminado permanentemente.'
            ]);
        } else {
            $usuario->restore();
            $this->dispatch('notify', [
                'variant' => 'success',
                'title' => '¡Éxito!',
                'message' => 'Usuario restaurado correctamente.'
            ]);
        }
        $this->reset(['user_seleccionado']);
        $this->showModalDELETE = false;
    }
    public function saveUser()
    {
        $this->validate();
        $this->dispatch('show-loader');
        try {
            if ($this->user_seleccionado) {
                $user = User::withTrashed()->find($this->user_seleccionado['id']);
                $user->name = $this->name;
                $user->email = $this->email;
                if ($this->password) {
                    $user->password = Hash::make($this->password);
                }
                $user->save();
                $user->syncRoles([$this->rol_seleccionado]);
                Medicos::where('id', $this->medico_seleccionado)
                    ->update([
                        'usuario_id' => $user->id
                    ]);
                $this->dispatch('notify', [
                    'variant' => 'success',
                    'title' => '¡Éxito!',
                    'message' => 'Usuario actualizado correctamente.'
                ]);
            } else {
                $user = User::create([
                    'name' => $this->name,
                    'email' => $this->email,
                    'password' => Hash::make($this->password),
                    'deleted' => Carbon::now()
                ]);
                $user->assignRole($this->rol_seleccionado);
                Medicos::where('id', $this->medico_seleccionado)
                    ->update([
                        'usuario_id' => $user->id
                    ]);

                $this->dispatch('notify', [
                    'variant' => 'success',
                    'title' => '¡Éxito!',
                    'message' => 'Usuario registrado correctamente.'
                ]);
            }
            $this->reset('name', 'email', 'password', 'password_confirmation', 'rol_seleccionado', 'medico_seleccionado', 'user_seleccionado');
            $this->showModal = false;
        } catch (\Exception $e) {
            $this->dispatch('notify', [
                'variant' => 'danger',
                'title' => 'Error',
                'message' => 'Hubo un error al registrar el usuario. Inténtalo de nuevo.'
            ]);
        }
    }

    public function render()
    {
        $roles = \Spatie\Permission\Models\Role::all();
        $this->medicos = Medicos::all();
        $query = User::withTrashed()->orderBy('id', 'desc');
        $paginator = $query->paginate(10);
        return view('livewire.usuario.users', ['medicos' => $this->medicos, 'paginator' => $paginator, 'data' => $paginator->items(), 'roles' => $roles]);
    }
}
