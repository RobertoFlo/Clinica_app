<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;
use App\Http\Requests\loginRequest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Illuminate\Support\Facades\Auth;
class LoginController extends Controller
{
    //
    public function login(loginRequest $request)
    {
        $user = $request->only(["email", "password"]);
      
            if (Auth::attempt($user)) {
                $request->session()->regenerate(); 
                return redirect()->intended('/'); 
            }else{

                return redirect()->intended('/login');
            }
        
    }
    public function logout(Request $request)
    {
        // 1. Cierra la sesión del usuario
        Auth::logout();

        // 2. Invalida la sesión actual
        $request->session()->invalidate();
        // 3. Regenera el token CSRF para prevenir ataques
        $request->session()->regenerateToken();

        // 4. Redirige al usuario a la página de inicio o login
        return redirect('/login'); 
    }
}
