<?php

namespace App\Http\Controllers\Frontend;

use App\DataTables\EmployeeDataTable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(EmployeeDataTable $dataTable)
    {
        if (Auth::check()) {
            $user = Auth::user();
            
            if ($user->hasRole('admin')) {
                return $dataTable->render('employees.index');
            }

            if ($user->hasRole('client')|| $user->hasRole('admin')) {
                $vehicles = Vehicle::all(); 
                return view('frontend.index',compact('vehicles'));
            }

        }

        return redirect('login');
    }
}
