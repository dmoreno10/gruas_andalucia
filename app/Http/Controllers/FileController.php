<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;

class FileController extends Controller
{
    public function index()
    {
        $files = File::all();  // Obtener todos los archivos desde la base de datos
        return view('files.index', compact('files'));  // Pasar los archivos a la vista
    }

    // Guardar archivo en la base de datos
    public function store(Request $request)
    {
        // Validar el archivo
        $request->validate([
            'file' => 'required|file|max:2048', // Máximo 2 MB
        ]);

        // Subir el archivo
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filePath = $file->store('documents');  // Guardar en el directorio "documents"

            // Guardar la información del archivo en la base de datos
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
