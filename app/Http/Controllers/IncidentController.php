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
        // Validar los datos de la incidencia
        $validated = $request->validate([
            'title' => 'required|max:100',
            'description' => 'required',
            'status' => 'required|in:abierto,cerrado,en_progreso', 
            'created_at' => 'required|date',
        ]);
    
        // Crear la incidencia con los datos validados
        $incident = Incident::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'status' => $validated['status'],
            'created_at' => $validated['created_at'],
            'user_id' => Auth::id(), 
        ]);
    
        
        return response()->json([
            'message' => 'Incidencia creada correctamente.',
            'incident' => $incident,
        ], 201);
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
    $incident = Incident::find($id);
    if (!$incident) {
        return response()->json(['error' => 'Incidencia no encontrada'], 404);
    }
    return response()->json(['incident' => $incident]);
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
