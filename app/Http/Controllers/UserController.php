<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\Support\Facades\Hash;
use Illuminate\Http\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash as FacadesHash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return view('users.index',['users'=>$users]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $datos=request()->all();
        // return response()->json($datos);
        $request->validate([
            'name' =>'required|max:100',
            'email' =>'required|unique:users',
            'password' =>'required|confirmed',
        ]);
        $usuario =new User();
        $usuario->name = $request->name;
        $usuario->email = $request->email;
        $usuario->password =FacadesHash::make($request['password']);
        $usuario->save() ;
        return redirect()->route('users.index');
    }

    /**
     * Display the specified resources.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
