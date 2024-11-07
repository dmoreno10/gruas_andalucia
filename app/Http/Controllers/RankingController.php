<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Ranking;
use Illuminate\Http\Request;

class RankingController extends Controller
{
     // Mostrar todos los rankings
     public function index()
     {
         $rankings = Ranking::with('employee')->orderBy('total_points', 'desc')->get();
         return view('rankings.index', compact('rankings'));
     }

     // Mostrar el formulario para crear un nuevo ranking
     public function create()
     {
         return view('rankings.create'); // Asegúrate de tener esta vista
     }

     // Guardar un nuevo ranking
     public function store(Request $request)
     {
         $request->validate([
             'employee_id' => 'required',
             'total_points' => 'required|numeric',
         ]);

         Ranking::create($request->all());
         return redirect()->route('rankings.index')->with('success', 'Ranking creado exitosamente.');
     }

     // Mostrar un ranking específico
     public function show(Ranking $ranking)
     {
         return view('rankings.show', compact('ranking')); // Asegúrate de tener esta vista
     }

     // Mostrar el formulario para editar un ranking
     public function edit(Ranking $ranking)
     {
         return view('rankings.edit', compact('ranking')); // Asegúrate de tener esta vista
     }

     // Actualizar un ranking específico
     public function update(Request $request, Ranking $ranking)
     {
         $request->validate([
             'employee_id' => 'required',
             'total_points' => 'required|numeric',
         ]);

         $ranking->update($request->all());
         return redirect()->route('rankings.index')->with('success', 'Ranking actualizado exitosamente.');
     }

     // Eliminar un ranking específico
     public function destroy(Ranking $ranking)
     {
         $ranking->delete();
         return redirect()->route('rankings.index')->with('success', 'Ranking eliminado exitosamente.');
     }
}
