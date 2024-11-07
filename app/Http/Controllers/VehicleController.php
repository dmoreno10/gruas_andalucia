<?php

namespace App\Http\Controllers;

use App\DataTables\VehiclesDataTable;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public function create()
    {
        return view('vehicles.create'); // Asegúrate de que esta vista exista
    }

    // Método para manejar el almacenamiento de un vehículo
    public function store(Request $request)
    {
        $request->validate([
            'brand' => 'required|string',
            'model' => 'required|string',
            'year' => 'required|integer',
            'type' => 'required|string',
            'color' => 'required|string',
            'status' => 'required|string',
            'photos' => 'nullable|array', // Asegúrate que las fotos sean opcionales
            'photos.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048' // Validaciones para cada foto
        ]);

        $vehicle = new Vehicle();
        $vehicle->brand = $request->input('brand');
        $vehicle->model = $request->input('model');
        $vehicle->year = $request->input('year');
        $vehicle->type = $request->input('type');
        $vehicle->color = $request->input('color');
        $vehicle->status = $request->input('status');

        // Manejo de fotos
        if ($request->has('photos')) {
            $photos = [];
            foreach ($request->file('photos') as $photo) {
                $path = $photo->store('vehicles', 'public'); // Almacena la foto
                $photos[] = $path; // Agrega la ruta al array
            }
            $vehicle->photo = json_encode($photos); // Convierte a JSON
        } else {
            $vehicle->photo = null; // O establece en null si no hay fotos
        }

        $vehicle->save(); // Guarda el vehículo

        return redirect()->route('vehicles.index')->with('success', 'Vehículo creado exitosamente.');
    }


}
