<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Mostrar la vista de registro
    public function showRegister()
    {
        return view('auth.register');
    }

    // Mostrar la vista de login
    public function showLogin()
    {
        return view('auth.login');
    }

    public function register(Request $request)
    {

        $request->validate([
            //'nombre' => 'required|unique:usuarios',
            'nombre' => 'required',
            'email' => 'required',
            'password' => 'required|min:6',
        ]);

        $usuario = Usuario::create([
            'nombre' => $request->nombre,
            'email' => $request->email,
            'contrasena' => Hash::make($request->password),
        ]);

        session(['usuario' => $usuario]);

        return redirect()->route('equipos.index');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $usuario = Usuario::where('email', $request->email)->first();

        if ($usuario && Hash::check($request->password, $usuario->password)) {
            session(['usuario' => $usuario]);
            return redirect()->route('equipos.index');
        } else {
            return back()->withErrors(['login' => 'Credenciales inválidas']);
        }
    }

    public function logout()
    {
        session()->forget('usuario');
        return redirect()->route('login');
    }
}
