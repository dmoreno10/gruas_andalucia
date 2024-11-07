<?php

namespace App\Http\Controllers;

use App\DataTables\TasksDataTable;
use App\Models\Employee;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TaskController extends Controller
{
  // Mostrar todas las tasks
  public function index(TasksDataTable $dataTable)
  {
      return $dataTable->render('tasks.index');
  }

  // Mostrar el formulario para crear una nueva task
  public function create()
  {
      $employees = Employee::all(); // Obtener todos los empleados
      return view('tasks.create', compact('employees'));
  }

  // Almacenar una nueva task
  public function store(Request $request)
  {
      $validatedData = $request->validate([
          'description' => 'required|string|max:255',
          'points' => 'required|integer',
          'employee_id' => 'required|exists:employees,id',
      ]);

      // Crear la nueva tarea
      Task::create($validatedData);

      // Redireccionar o retornar una respuesta
      return redirect()->route('tasks.index')->with('success', 'Task created successfully.');
  }


  public function complete($id)
  {
      $task = Task::findOrFail($id);
      $task->completed = true; // Marcar la tarea como completada
      $task->save();
      // Aquí podrías agregar lógica para sumar puntos al empleado
      $this->addPointsToEmployee($task->employee_id, $task->points);

      return redirect()->route('tasks.index')->with('success', 'Tarea completada y puntos añadidos.');
  }

  public function destroy($id)
  {
      $task = Task::findOrFail($id);
      $task->delete();

      return redirect()->route('tasks.index')->with('success', 'Tarea anulada correctamente.');
  }

  // Mostrar una task específica
  public function show($id) {
   $task=Task::findOrFail($id);
   return response()->json($task);
    }

  public function start($id)
    {
    $task = Task::findOrFail($id);
    return view('tasks.timer', compact('task'));
    }
  // Mostrar el formulario para editar una task
  public function edit(Task $task)
  {
      $employees = Employee::all(); // Obtener todos los empleados
      return view('tasks.edit', compact('task', 'employees'));
  }

  // Actualizar una task específica
  public function update(Request $request, Task $task)
  {
      $request->validate([
          'description' => 'required|string',
          'points' => 'required|integer',
          'employee_id' => 'required|exists:employees,id',
      ]);

      $task->update($request->all());
      return redirect()->route('tasks.index')->with('success', 'Task actualizada exitosamente.');
  }
  public function addPointsToEmployee($employeeId, $points)
{
    // Lógica para añadir puntos al empleado
    $employee = Employee::find($employeeId);

    if ($employee) {
        $employee->points += $points; // Asumiendo que hay una propiedad 'points'
        $employee->save();
    }
}
public function stop($id)
{
    $task = Task::findOrFail($id);

    // Obtener el tiempo enviado en minutos
    $timeInMinutes = request()->input('time');

    // Convertir el tiempo total a horas y minutos
    $totalMinutes = $task->time_minutes + $timeInMinutes; // Sumar el tiempo existente
    $hours = floor($totalMinutes / 60); // Obtener las horas
    $minutes = $totalMinutes % 60; // Obtener los minutos restantes

    // Guardar el tiempo en formato total de minutos
    $task->time_minutes = $totalMinutes; // Puedes guardarlo como minutos totales o crear un nuevo campo para horas
    $task->save();

    return response()->json(['success' => true, 'message' => 'Tarea detenida y tiempo guardado.']);
}

public function cancel($id)
{
    $task = Task::findOrFail($id);
    // Lógica para cancelar la tarea
    // Por ejemplo, cambiar el estado de la tarea a 'cancelada'
    $task->status = 'cancelada';
    $task->save();

    return response()->json(['success' => true, 'message' => 'Tarea cancelada.']);
}



}
