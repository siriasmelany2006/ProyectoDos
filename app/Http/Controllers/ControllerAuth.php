<?php

namespace App\Http\Controllers;

use App\Models\Tienda;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laravel\Socialite\Facades\Socialite;

class ControllerAuth extends Controller
{
    // Pantalla de inicio de sesión
    public function login()
    {
        if (Auth::check()) {
            return redirect($this->destino(Auth::user()));
        }

        return view('auth.login');
    }

    // Manda al usuario a Google (siempre pide elegir la cuenta)
    public function redirigirGoogle()
    {
        return Socialite::driver('google')
            ->with(['prompt' => 'select_account'])
            ->redirect();
    }

    // Google devuelve al usuario aquí
    public function callbackGoogle(Request $request)
    {
        try {
            $google = Socialite::driver('google')->user();
        } catch (\Throwable $e) {
            report($e);

            return redirect()->route('login')
                ->with('error', 'No se pudo iniciar sesión con Google. Intenta de nuevo.');
        }

        // Primero por google_id; si no, por correo (así se reconoce al administrador)
        $usuario = User::where('google_id', $google->getId())->first()
            ?? User::where('correo', $google->getEmail())->first();

        if ($usuario) {
            $usuario->update([
                'google_id' => $google->getId(),
                'nombre'    => $google->getName() ?: $usuario->nombre,
                'foto'      => $google->getAvatar(),
            ]);
        } else {
            // Usuario nuevo: rol tienda y se le crea su tienda automáticamente
            $usuario = DB::transaction(function () use ($google) {
                $nuevo = User::create([
                    'google_id' => $google->getId(),
                    'nombre'    => $google->getName() ?: $google->getEmail(),
                    'correo'    => $google->getEmail(),
                    'foto'      => $google->getAvatar(),
                    'rol'       => 'tienda',
                ]);

                Tienda::create([
                    'id_usuario' => $nuevo->id_usuario,
                    'nombre'     => 'Tienda de ' . $nuevo->nombre,
                    'correo'     => $nuevo->correo,
                    'destacada'  => false,
                    'activa'     => true,
                ]);

                return $nuevo;
            });
        }

        Auth::login($usuario);
        $request->session()->regenerate();

        return redirect($this->destino($usuario));
    }

    // Cerrar sesión
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }

    // A dónde va cada rol después de entrar
    private function destino(User $usuario): string
    {
        return $usuario->esAdmin()
            ? route('admin.pedidos.index')
            : route('tienda.mi-tienda');
    }
}