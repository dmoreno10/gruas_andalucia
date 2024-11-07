<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Container\Attributes\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log as FacadesLog;

class EventController extends Controller
{
    public function getData()
    {
        try {
            // Selecciona solo las columnas que existen
            $events = Event::select('id', 'user', 'start_time', 'title', 'description') // Incluye solo columnas existentes
                ->get();
            return response()->json($events);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Server error'], 500);
        }
    }

    public function index()
    {
        // Recuperar todos los eventos
        $events = Event::all();

        // Pasar los eventos a la vista
        return view('events.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Mostrar la vista con el formulario para crear un evento
        return view('events.create');
    }

    public function store(Request $request)
    {
        // Validar los datos recibidos
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'start_time' => 'required|date',
            'description' => 'nullable|string',
            // Eliminar 'end_time' de la validación
        ]);

        // Crear el evento
        $event = Event::updateOrCreate(
            ['id' =>  $request->id ?? null],
            [
                'title' => $validated['title'],
                'description' => $validated['description'],
                'start_time' => $validated['start_time'],
                // Eliminar 'end_time' de aquí
            ],
        );


        return response()->json(['message' => 'Evento creado o updateado', 'event' => $event], 200);

    }

    // Puedes agregar otros métodos, como eliminar el evento
    public function destroy($id)
    {
        $event = Event::findOrFail($id);
        $event->delete();

        return response()->json(['message' => 'Evento eliminado correctamente'], 200);
    }
}
