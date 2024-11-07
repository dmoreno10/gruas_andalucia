<?php

namespace App\Http\Controllers;

use App\DataTables\ReservationDataTable;
use App\Models\Reservation; // Asegúrate de tener este modelo
use App\Models\User;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    // Muestra una lista de todas las reservas
    public function index(ReservationDataTable $dataTable)
    {
        return $dataTable->render('reservations.index'); // Cargar la vista con el DataTable
    }

    // Muestra el formulario para crear una nueva reserva
    public function create()
    {
        return view('reservations.create'); // Asegúrate de tener esta vista
    }

    // Almacena una nueva reserva en la base de datos
    public function store(Request $request)
    {
        $request->validate([
            'client_name' => 'required|string|max:255',
            'reservation_date' => 'required|date',
            'status' => 'required|string',
        ]);

        // Verifica si el cliente existe
        $client = User::where('name', $request->client_name)->first(); // Cambia 'name' si usas otro campo

        if (!$client) {
            return redirect()->back()->withErrors(['client_name' => 'El cliente no existe.'])->withInput();
        }

        Reservation::create($request->all());

        return redirect()->route('reservations.index')->with('success', 'Reserva creada exitosamente.');
    }
    // Muestra los detalles de una reserva específica
    public function show($id)
    {
        $reservation = Reservation::findOrFail($id);
        return view('reservations.show', compact('reservation')); // Asegúrate de tener esta vista
    }

    // Muestra el formulario para editar una reserva existente
    public function edit($id)
    {
        $reservation = Reservation::findOrFail($id);
        return view('reservations.edit', compact('reservation')); // Asegúrate de tener esta vista
    }

    // Actualiza una reserva existente en la base de datos
    public function update(Request $request, $id)
    {
        $request->validate([
            'client_name' => 'required|string|max:255',
            'reservation_date' => 'required|date',
            'status' => 'required|string',
        ]);

        $reservation = Reservation::findOrFail($id);
        $reservation->update($request->all());

        return redirect()->route('reservations.index')->with('success', 'Reserva actualizada exitosamente.');
    }

    // Elimina una reserva específica de la base de datos
    public function destroy($id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->delete();

        return redirect()->route('reservations.index')->with('success', 'Reserva eliminada exitosamente.');
    }
}
