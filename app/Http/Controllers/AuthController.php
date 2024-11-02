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
            'nombre' => 'required',
            'email' => 'required|email|unique:usuarios,email',
            'password' => 'required|min:4',
        ]);

        $usuario = Usuario::create([
            'nombre' => $request->nombre,
            'email' => $request->email,
            'contrasena' => Hash::make($request->password),
        ]);

        session(['usuario' => $usuario]);

        return redirect()->route('home');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:4',
        ]);

        $usuario = Usuario::where('email', $request->email)->first();

        if ($usuario && Hash::check($request->password, $usuario->contrasena)) {
            session(['usuario' => $usuario]);

            // Redirigir en caso de ser administrador
            if ($usuario->email === 'admin@super.com') {
                return redirect()->route('admin.dashboard');
            }

            return redirect()->route('home');
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
