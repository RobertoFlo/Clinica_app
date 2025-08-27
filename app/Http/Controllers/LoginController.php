<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\loginRequest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Illuminate\Support\Facades\Hash;
class LoginController extends Controller
{
    //
    public function login(loginRequest $request):JsonResponse
    {
   
        dd($request->only(["email","password"]));
        $user = $request->only(["email","password"]);
        if($request->validated()){

            dd(vars: $user);
        }

        // // Log the user in (you might want to use Laravel's Auth facade here)
        // auth()->login($user);

        // return redirect()->route('dashboard'); // Redirect to a dashboard or home page
    }
}
