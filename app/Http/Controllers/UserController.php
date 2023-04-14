<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;


class UserController extends Controller
{
    public function handleSessionStart(string $email)
    {
        // Busco en la BD si existe un usuario con el email recibido
        $storedUser = User::where('email', $email)->get()->first();

        if($storedUser){
            $user = $storedUser;
        }else{ // Si no existe un usuario con ese email, lo genero
            $name = substr($email, 0, strpos($email, '@')); // Guardo un string con lo que esté antes del '@'

            $user = User::create([
                'name' => $name,
                'lastname' => '*lastname',
                'email' => $email,
                'password' => Hash::make('SecurePassword!'),
            ]);

            event(new Registered($user));
        }

        Auth::login($user);
        return $user;
    }

}
