<?php

namespace App\Http\Controllers;

use App\DataTables\CompanyDataTable;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function data() {
        return response()->json(Company::all());
    }

    // Función para mostrar la lista de empresas con DataTable
    public function index(CompanyDataTable $dataTable)
    {
        // No necesitamos cargar los datos manualmente, el DataTable se encarga de eso
        return $dataTable->render('companies.index'); // Renderiza la vista con el DataTable
    }

    // Función para mostrar el formulario de creación de empresa
    public function create()
    {
        return view('companies.create');
    }

    // Función para almacenar una nueva empresa
    public function store(Request $request)
    {
        // Validación de los datos del formulario
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'email' => 'required|string|email|max:255|unique:companies,email',
        ]);

        // Crear una nueva empresa con los datos validados
        Company::create($validated);

        // Redirigir con un mensaje de éxito
        return redirect()->route('companies.index')->with('success', 'Empresa creada con éxito.');
    }

    // Función para mostrar el formulario de edición de empresa
    public function edit(Company $company)
    {
        return view('companies.edit', compact('company'));
    }

    public function show($id)
    {
        // Intentamos encontrar la empresa por el ID
        $company = Company::find($id);

        // Si no se encuentra la empresa, retornamos un error 404
        if (!$company) {
            return response()->json(['error' => 'Empresa no encontrada'], 404);
        }

        // Si la empresa es encontrada, la retornamos
        return response()->json($company);
    }

    // Función para actualizar una empresa
    public function update(Request $request, Company $company)
    {
        // Validación de los datos del formulario
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'email' => 'required|string|email|max:255|unique:companies,email,' . $company->id,
        ]);

        // Actualizar la empresa con los datos validados
        $company->update($validated);

        return response()->json(['message' => 'Empresa actualizada con éxito.']);
    }

    // Función para eliminar una empresa
    public function destroy(Company $company)
    {
        // Eliminar la empresa
        $company->delete();

        // Redirigir con un mensaje de éxito
        return redirect()->route('companies.index')->with('success', 'Empresa eliminada con éxito.');
    }
}
