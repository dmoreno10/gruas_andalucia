<?php

namespace App\Http\Controllers;

use App\Models\Point;
use App\Models\Ranking;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PointController extends Controller
{
    public function index(): JsonResponse
    {
        // Retorna los puntos en formato JSON
        $points = Point::all();
        return response()->json($points);
    }
    public function __construct()
    {
    $this->middleware('auth:api');
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'points' => 'required|integer',
            'description' => 'nullable|string',
        ]);

        $point = Point::create($validated);
        $this->updateRanking($validated['employee_id']);

        return response()->json($point, 201);
    }

    public function update(Request $request, $id)
    {
        $point = Point::findOrFail($id);
        $validated = $request->validate([
            'points' => 'required|integer',
            'description' => 'nullable|string',
        ]);

        $point->update($validated);
        $this->updateRanking($point->employee_id);

        return response()->json($point);
    }

    public function destroy($id)
    {
        $point = Point::findOrFail($id);
        $point->delete();
        $this->updateRanking($point->employee_id);

        return response()->json(null, 204);
    }

    protected function updateRanking($employeeId)
    {
        $totalPoints = Point::where('employee_id', $employeeId)->sum('points');
        Ranking::updateOrCreate(
            ['employee_id' => $employeeId],
            ['total_points' => $totalPoints]
        );
    }
}
