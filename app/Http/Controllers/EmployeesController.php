<?php

namespace App\Http\Controllers;

use App\DataTables\EmployeeDataTable;
use App\Models\Company;
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
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email',
            'company_id' => 'required|exists:companies,id',
            'status' => 'required|string',
            'department' => 'nullable|string',
            'user_id' => 'nullable|exists:users,id',
            'position' => 'nullable|string'
        ]);

        $employee = Employee::create($validated);

        return response()->json($employee, 201);
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
    $employee = Employee::find($id);
    if (!$employee) {
        return response()->json(['error' => 'Empleado no encontrado'], 404);
    }
    $companies = Company::all();
    return response()->json(['employee' => $employee, 'companies' => $companies]);
}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validación de los datos
        $validatedData = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'position' => 'required|string',
            'department' => 'required|string',
            'company_id' => 'required|exists:companies,id', // Validación de company_id
            'status' => 'required|string',
            'user_id' => 'nullable|integer',
        ]);

        // Encuentra el empleado por su ID
        $employee = Employee::findOrFail($id);
        $employee->update($validatedData);

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
