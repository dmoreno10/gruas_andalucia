<?php

namespace App\Http\Controllers;

use App\DataTables\AccessLogDataTable;
use App\Models\AccessLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccessLogController extends Controller
{
    
    public function index(AccessLogDataTable $dataTable)
    {
        return $dataTable->render('accesslogs.index');
    }


    public function create()
    {
        return view('accesslogs.create');
    }


    public function store(Request $request)
    {
        // Validar la entrada
        $request->validate([
            'ip_address' => 'required|ip',
            'user_agent' => 'required|string',
            'status' => 'required|in:success,failed',
        ]);

        // Crear un nuevo AccessLog
        AccessLog::create([
            'ip_address' => $request->ip_address,
            'user_agent' => $request->user_agent,
            'status' => $request->status,
        ]);

        // Redirigir a la lista de logs de acceso
        return redirect()->route('accesslogs.index')->with('success', 'Access log creado correctamente.');
    }


    public function show(string $id)
    {
        // Obtener el acceso log por ID
        $accessLog = AccessLog::findOrFail($id);
        return view('accesslogs.show', compact('accessLog'));
    }


    public function edit(string $id)
    {
        // Obtener el acceso log por ID
        $accessLog = AccessLog::findOrFail($id);
        return view('accesslogs.edit', compact('accessLog'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validar la entrada
        $request->validate([
            'ip_address' => 'required|ip',
            'user_agent' => 'required|string',
            'status' => 'required|in:success,failed',
        ]);

        // Obtener el acceso log por ID
        $accessLog = AccessLog::findOrFail($id);

        // Actualizar los campos
        $accessLog->update([
            'ip_address' => $request->ip_address,
            'user_agent' => $request->user_agent,
            'status' => $request->status,
        ]);

        // Redirigir a la lista de logs de acceso
        return redirect()->route('accesslogs.index')->with('success', 'Access log actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Obtener el acceso log por ID y eliminarlo
        $accessLog = AccessLog::findOrFail($id);
        $accessLog->delete();

        // Redirigir a la lista de logs de acceso con un mensaje de éxito
        return redirect()->route('accesslogs.index')->with('success', 'Access log eliminado correctamente.');
    }

public function login(Request $request)
{
    // Validar el usuario
    if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
        // Log de acceso exitoso
        AccessLog::create([
            'user_id' => Auth::id(),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'status' => 'success',
        ]);

        return redirect()->route('dashboard');
    } else {
        // Log de acceso fallido
        AccessLog::create([
            'user_id' => null,  // En caso de un acceso fallido, no asociamos usuario
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'status' => 'failed',
        ]);

        return back()->withErrors(['email' => 'Invalid credentials']);
    }
}

}
