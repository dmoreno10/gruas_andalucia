<?php

namespace App\Http\Controllers;

use App\DataTables\VehiclesDataTable;
use App\Models\MunicipalDeposit;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleController extends Controller
{

    public function searchVehicle(Request $request)
    {
        $searchQuery = $request->input('searchQuery');

        // Buscar vehículo por matrícula
        $vehicles = Vehicle::where('license_plate', $searchQuery)->first();
        
        if ($vehicles) {
            // Obtener información del depósito
            $municipalDeposit = $vehicles->municipalDeposit;
            $response = [
                'vehicle' => $vehicles,
                'deposit' => $municipalDeposit ? $municipalDeposit->name : 'No asignado'
            ];
            return response()->json($response);
        }

        return response()->json(['message' => 'Vehículo no encontrado'], 404);
    }

    public function index(VehiclesDataTable $dataTable)
    {
        $vehiclesInDeposit = Vehicle::where('status', 'En Depósito')->count();
        $vehiclesReleased = Vehicle::where('status', 'Liberado')->count();
        $vehiclesInReview = Vehicle::where('status', 'En Revisión')->count();
        return $dataTable->render('vehicles.index', compact('vehiclesInDeposit', 'vehiclesReleased', 'vehiclesInReview'));
    }
    public function create()
{
    $municipalDeposits = MunicipalDeposit::all(); 
    return view('vehicles.create', compact('municipalDeposits'));
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
            'license_plate' => 'required|string', 
            'photos' => 'nullable|array', 
            'photos.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048' 
        ]);
        $vehicle = new Vehicle();
        $vehicle->brand = $request->input('brand');
        $vehicle->model = $request->input('model');
        $vehicle->year = $request->input('year');
        $vehicle->type = $request->input('type');
        $vehicle->color = $request->input('color');
        $vehicle->status = $request->input('status');
        $vehicle->license_plate = $request->input('license_plate');
        $vehicle->municipal_deposit_id =$request->input('municipal_deposit_id');

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
    public function show($id)
    {
        $vehicle = Vehicle::findOrFail($id);
        $photos = json_decode($vehicle->photos, true); // Obtener las rutas de las fotos

        return view('vehicles.show', compact('vehicle', 'photos'));
    }



}
