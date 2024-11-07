<?php

namespace App\Http\Controllers;

use App\Models\AccessLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);


        $credentials = $request->only('email', 'password');


        if (Auth::attempt($credentials)) {
            AccessLog::create([
                'user_id' => Auth::user()->id,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'status' => 'success',  // Establecer el estado de éxito
            ]);

            return redirect('/');
        }


        return back()->withErrors([
            'email' => 'Las credenciales no coinciden con nuestros registros.',
        ])->withInput($request->only('email'));
    }

}
