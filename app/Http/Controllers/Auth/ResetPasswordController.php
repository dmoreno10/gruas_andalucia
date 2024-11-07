<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ResetPasswordController extends Controller
{
    use ResetsPasswords; // Incluye el trait para manejar el restablecimiento de contraseñas

    // Muestra el formulario de restablecimiento de contraseña
    public function showResetForm(Request $request, $token = null)
    {
        return view('auth.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    // Maneja la solicitud de restablecimiento de contraseña
    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
            'token' => 'required'
        ]);

        $response = Password::reset($request->only('email', 'password', 'password_confirmation', 'token'), function ($user, $password) {
            $user->password = bcrypt($password);
            $user->save();
            event(new PasswordReset($user));
        });

        return $response == Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __('Password reset successful!'))
            : back()->withErrors(['email' => __('Failed to reset password. Please try again.')]);
    }
}
