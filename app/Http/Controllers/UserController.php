<?php

namespace App\Http\Controllers;

use App\DataTables\UsersDataTable;
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
    public function index(UsersDataTable $dataTable)
    {
        return $dataTable->render('users.index');
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
    public function show($id)
    {
        $usuario =User::find($id);
        return view('users.show',['user'=>$usuario]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit( $id)
    {
      $usuario=User::findOrFail($id);
      return view('users.edit',['usuario'=>$usuario]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
{

    $usuario = User::findOrFail($id);


    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users,email,' . $usuario->id,
    ]);


    $usuario->name = $request->input('name');

    $usuario->save();


    return redirect()->route('users.index')->with('success', 'Usuario actualizado correctamente.');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
       User::destroy($id);
       return redirect()->route('users.index');
    }
}
