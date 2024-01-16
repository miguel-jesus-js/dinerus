<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Notifications\ResetPassword;
use App\Models\User;

class LoginController extends Controller
{
    public static function serviceLogin(Request $request)
    {
        // Equivalente a tablas: 1 = clientes, 2 = repartidores, 3 = restaurantes     
        $request->validate([
            'email'         => ['required', 'email', 'string'],
            'password'      => ['required', 'string']
        ]);
        $credenciales = $request->only('email', 'password'); //obtiene solo esos dos datos
        if (Auth::attempt($credenciales)) {
            $token = Str::random(60);
            Auth::user()->forceFill(['api_token' => hash('sha256', $token)])->save();
            return json_encode(['type' => 'success', 'message' => 'Sesión iniciada', 'token' => $token, 'userdata' => Auth::user()]);
        }
        return json_encode(['type' => 'error', 'message' => 'Credenciales invalidas']);
    }
    public function resetPassword(Request $request)
    {
        $email = $request->all();

        if (User::where('email', $email['email'])->exists()) {

            try{
                $usuario = User::where('email', $email['email'])->first();
                $password = Str::random(10);
                $usuario->password = Hash::make($password);
                $usuario->save();
                $usuario->notify(new ResetPassword($password));
                return json_encode(['type' => 'success', 'title' => 'Éxito', 'text' => 'Se envio la nueva contraseña al correo: ' .$email['email']]);
            }catch(\Exception $e){
                return json_encode(['type' => 'error', 'title' => 'Error', 'text' => $e]);
            }

        } 
        return json_encode(['type' => 'error', 'title' => 'Error', 'text' => 'El correo no existe']);
    }
}
