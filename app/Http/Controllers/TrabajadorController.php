<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TrabajadorController extends Controller
{
    public function index(){
        return view('trabajadores.index');
    }
    public function create(){
        return view('trabajadores.create');

    }
    public function show($trabajador){
        return view('trabajadores.show');

    }
}
