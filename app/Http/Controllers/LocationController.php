<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function index() {
        $locations = Location::all();
        return view('locations.index', compact('locations'));
    }

    public function store(Request $request) {
        $location = Location::create($request->only(['name', 'latitude', 'longitude']));
        return response()->json($location, 201);
    }

    public function show($id) {
        return Location::findOrFail($id);
    }

    public function update(Request $request, $id) {
        $location = Location::findOrFail($id);
        $location->update($request->only(['name', 'latitude', 'longitude']));
        return response()->json($location, 200);
    }

    public function destroy($id) {
        $location = Location::findOrFail($id);
        $location->delete();
        return response()->json(null, 204);
    }
}
