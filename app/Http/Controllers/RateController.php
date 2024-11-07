<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Rate;
use Illuminate\Http\Request;

class RateController extends Controller
{
    public function index()
    {
        $rates = Rate::all();
        return view('rate.index', compact('rates'));
    }

    public function store(Request $request)
    {
        $rate = Rate::create($request->all());
        return response()->json($rate, 201);
    }
    public function rankings()
    {
    $rankings = Employee::withSum('points', 'points')
                ->orderByDesc('points_sum_points')
                ->get()
                ->map(function ($employee) {
                    return [
                        'id' => $employee->id,
                        'name' => $employee->name,
                        'total_points' => $employee->points_sum_points
                    ];
                });

    return response()->json($rankings);
    }

    public function show(Rate $rate)
    {
        return $rate;
    }

    public function update(Request $request, Rate $rate)
    {
        $rate->update($request->all());
        return response()->json($rate, 200);
    }

    public function destroy(Rate $rate)
    {
        $rate->delete();
        return response()->json(null, 204);
    }
}
