<?php

namespace App\Http\Controllers;

use App\DataTables\EmployeeDataTable;
use App\Models\Employee;
use App\Models\Employees;
use Barryvdh\DomPDF\PDF;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index(EmployeeDataTable $dataTable, Request $request)
{
    // Si es una solicitud API, devolver JSON
    if ($request->wantsJson()) {
        return response()->json(Employee::all());
    }

    // Si no es API, renderiza la vista con el DataTable
    return $dataTable->render('employees.index');
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('employees.create'); // Cambia a la vista correspondiente
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:employees',
        'position' => 'required|string|max:255',
        'department' => 'required|string|max:255',
        'status' => 'required|string|in:activo,inactivo', // Asegúrate de validar el status
    ]);

    Employee::create($request->all());

    return redirect()->route('employees.index')->with('success', 'Empleado creado con éxito.');
}


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $employee = Employee::findOrFail($id);
            return response()->json($employee);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Empleado no encontrado'], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Obtén el empleado por ID
        $employee = Employee::findOrFail($id);

        // Retorna la vista de edición con los datos del empleado
        return view('employees.edit', ['employee' => $employee]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validación de los datos
        $request->validate([
            'name' => 'required|max:100',
            'email' => 'required|email|max:255|unique:employees,email,'.$id,
            'position' => 'required|max:100',
            'department' => 'required|max:100',
        ]);

        // Encuentra el empleado por su ID
        $employee = Employee::findOrFail($id);

        // Actualiza los campos del empleado con los datos del formulario
        $employee->name = $request->name;
        $employee->email = $request->email;
        $employee->position = $request->position;
        $employee->department = $request->department;
        $employee->save();

        return response()->json(['message' => 'Empleado actualizado correctamente.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Employee::destroy($id);
        return redirect()->route('employees.index')->with('success', 'Empleado eliminado exitosamente.');
    }
    public function downloadEmployeeProfile($id)
    {
        // Encuentra el empleado por ID
        $employee = Employee::findOrFail($id);

        // Inyectar PDF en lugar de usarlo de manera estática
        $pdf = app('dompdf.wrapper');
        $pdf->loadView('pdf.employee_profile', compact('employee'));

        // Descargar el PDF, usando el nombre del empleado en el archivo
        return $pdf->download('employee_profile_' . $employee->name . '.pdf');
    }


}
