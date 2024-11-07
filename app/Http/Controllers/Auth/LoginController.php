<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\AccessLog; // Importa el modelo de AccessLog
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    /**
     * Override this method to register the login event.
     *
     * @param Request $request
     * @param mixed   $user
     * @return \Illuminate\Http\Response
     */
    protected function authenticated(Request $request, $user)
    {
        try{
        // Verificar si el usuario está autenticado correctamente
        if ($user) {
            // Log de acceso exitoso
            AccessLog::create([
                'user_id' => $user->id,  // Guarda el ID del usuario que se ha autenticado
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'status' => 'success',  // Establecer el estado de éxito
            ]);
            $token = $user->createToken('practica')->plainTextToken; // Ejemplo de Laravel Sanctum

        }
    }
        catch(Exception $e){
            Log::error('Error registrando el acceso: ' . $e->getMessage());
        }
        // Redirigir al dashboard o la ruta correspondiente después del login
        return redirect()->route('dashboard');  // O la ruta que desees redirigir
    }

    /**
     * Handle the logout request.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        // Registrar en la tabla de access_logs cuando el usuario cierre sesión
        AccessLog::create([
            'user_id' => Auth::id(), // ID del usuario que cierra sesión
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'status' => 'logout', // Estado de cierre de sesión
        ]);

        // Ejecutar el logout de Laravel
        Auth::logout();

        // Redirigir al usuario al login o cualquier otra página
        return redirect()->route('login');
    }

    /**
     * Handle failed login attempts.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        // Registrar un log en caso de fallo en la autenticación
        AccessLog::create([
            'user_id' => null,  // No hay usuario autenticado en caso de fallo
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'status' => 'failed',  // Estado 'failed' para fallo de autenticación
        ]);

        // Redirigir al login con un mensaje de error
        return back()->withErrors(['email' => 'Credenciales inválidas']);
    }
}
