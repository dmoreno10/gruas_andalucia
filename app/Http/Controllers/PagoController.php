<?php

namespace App\Http\Controllers;

use App\Models\Pago;
use Illuminate\Http\Request;

class PagoController extends Controller
{
    public function index()
    {
        return view('pagos.index');
    }

    public function store(Request $request)
    {
        $pago = Pago::updateOrCreate(
            ['id' => $request->id],
            ['descripcion' => $request->descripcion, 'monto' => $request->monto]
        );

        return response()->json($pago);
    }

    public function destroy($id)
    {
        Pago::find($id)->delete();
        return response()->json(['success' => 'Pago eliminado correctamente.']);
    }
}
