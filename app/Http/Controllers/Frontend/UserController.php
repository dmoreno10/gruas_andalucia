<?php

namespace App\Http\Controllers\Frontend;

use App\DataTables\EmployeeDataTable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DocumentalGestion;
use App\Models\Vehicle;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
            
        $vehicles = Vehicle::all(); 
        return view('frontend.index',compact('vehicles'));
    }
}
