<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;

class FileController extends Controller
{
    public function index()
    {
        $files = File::all(); 
        return view('files.index', compact('files'));
    }

    // Guardar archivo en la base de datos
    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:2048',
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filePath = $file->store('documents');

            File::create([
                'file_name' => $file->getClientOriginalName(),
                'file_path' => $filePath,
                'mime_type' => $file->getClientMimeType(),
                'file_size' => $file->getSize(),
            ]);
            
            return back()->with('success', 'Archivo subido y registrado correctamente.');
        }

        return back()->with('error', 'No se ha seleccionado un archivo.');
    }
}
