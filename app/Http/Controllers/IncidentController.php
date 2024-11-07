<?php

namespace App\Http\Controllers;

use App\DataTables\IncidentsDataTable;
use App\Models\Incident;
use App\Models\User;
use App\Notifications\IncidentCreated;
use App\Notifications\IncidentUpdated;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class IncidentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(IncidentsDataTable $dataTable){
        $notifications = Auth::user()->notifications;
        return $dataTable->render('incidents.index',compact('notifications'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('incidents.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:100',
            'description' => 'required',
            'status' => 'required',
            'created_at' => 'required|date',
        ]);

        $incident = Incident::create([
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
            'created_at' => $request->created_at,
            'user_id' => Auth::id(),
        ]);
        // Enviar notificación a todos los usuarios
        $users = User::all();
        return redirect()->route('incidents.index')->with('success', 'Incidente creado exitosamente.');
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $incident = Incident::findOrFail($id);
            return response()->json($incident);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Incidencia no encontrada'], 404);
        }
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Obtén la incidencia por ID
        $incident = Incident::findOrFail($id);

        // Retorna la vista de edición con los datos de la incidencia
        return view('incidents.edit', ['incident' => $incident]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
{
    // Validación de los datos
    $request->validate([
        'title' => 'required|max:100',
        'description' => 'required',
        'status' => 'required',
    ]);

    // Encuentra el incidente por su ID
    $incident = Incident::findOrFail($id);

    // Actualiza los campos del incidente con los datos del formulario
    $incident->title = $request->title;
    $incident->description = $request->description;
    $incident->status = $request->status;
    $incident->save();

    // Redirecciona con un mensaje de éxito
    $users = User::all();

    return response()->json(['message' => 'Usuario actualizado correctamente.']);

}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
       Incident::destroy($id);
       return redirect()->route('incidents.index');
    }
}
