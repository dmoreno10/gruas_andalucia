<?php

namespace App\Http\Controllers;

use App\DataTables\DepositMunicipalDataTable;
use App\Models\DepositoMunicipal;
use App\Models\MunicipalDeposit;
use Illuminate\Http\Request;

class MunicipalDepositController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(DepositMunicipalDataTable $dataTable)
    {
        return $dataTable->render('municipal-deposit.index');
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'direction' => 'required|string',
            'town' => 'required|string',
            'status' => 'required|integer',
            'phone' => 'required|integer',
            'mobile_phone' => 'required|integer',
        ]);

        $municipalDeposit = MunicipalDeposit::create($validated);

        return response()->json($municipalDeposit, 201);
    }

    public function show(MunicipalDeposit $municipalDeposit)
    {
        return response()->json($municipalDeposit);
    }

    public function edit(MunicipalDeposit $municipalDeposit)
    {
        return response()->json($municipalDeposit);
    }

    public function update(Request $request, MunicipalDeposit $municipalDeposit)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'direction' => 'required|string',
            'town' => 'required|integer',
            'status' => 'required|integer',
            'phone' => 'required|integer',
            'mobile_phone' => 'required|integer',
        ]);

        $municipalDeposit->update($validated);

        return response()->json(['message' => 'Depósito Municipal actualizado correctamente.']);
    }

    public function destroy(MunicipalDeposit $municipalDeposit)
    {
        $municipalDeposit->delete();

        return response()->json(['message' => 'Depósito Municipal eliminado correctamente.']);
    }
}
