<?php

namespace App\Http\Controllers;


use App\Models\Configuration;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ConfigurationController extends Controller
{

    public function index()
    {
        $configuration = Configuration::find(1);


        if (!$configuration) {
            return redirect()->back()->withErrors('No se encontró la configuración.');
        }
        $image = $configuration->file ? $configuration->file->file_path : null;
        return view('configuration.index', [
            'configuration' => $configuration,
            'image' => $image, // Puedes pasar la imagen a la vista si es necesario
        ]);
    }



    public function store(Request $request)
{
    // Validar los archivos de imagen
    $request->validate([
        'user_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',  // Imagen de usuario
        'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',         // Logo
    ]);

    // Suponemos que solo tienes una configuración
    $configuration = Configuration::find(1);

    // Procesar la imagen de usuario, si fue enviada
    if ($request->hasFile('user_image')) {
        $image = $request->file('user_image');
        $imageName = time() . '_user.' . $image->getClientOriginalExtension();
        $imagePath = $image->storeAs('user_images', $imageName, 'public');

        // Verificar que la imagen se guardó correctamente
        if (Storage::disk('public')->exists('user_images/' . $imageName)) {
            // Crear un registro en la tabla de archivos para la imagen de usuario
            $file = File::create([
                'filename' => $imageName,
                'file_path' => $imagePath,
                'mime_type' => $image->getClientMimeType(),
                'file_size' => $image->getSize(),
            ]);

            // Asignar el ID del archivo de imagen de usuario a la configuración
            $configuration->user_image_id = $file->id;
            if(Auth::check()){
            $user = Auth::user(); // Obtiene al usuario autenticado
            $user->profile_image = $imagePath;  // Guardar la ruta de la imagen en el campo 'profile_image' del usuario
            $user->save(); // Persistir el cambio
            }
        }
    }

    // Procesar el logo, si fue enviado
    if ($request->hasFile('logo')) {
        $logo = $request->file('logo');
        $logoName = time() . '_logo.' . $logo->getClientOriginalExtension();
        $logoPath = $logo->storeAs('logos', $logoName, 'public');

        // Verificar que el logo se guardó correctamente
        if (Storage::disk('public')->exists('logos/' . $logoName)) {
            // Guardar la ruta del logo en la configuración
            $configuration->logo = $logoPath;

            // Crear un registro en la tabla de archivos para el logo
            $file = File::create([
                'filename' => $logoName,
                'file_path' => $logoPath,
                'mime_type' => $logo->getClientMimeType(),
                'file_size' => $logo->getSize(),
            ]);

            // Asignar el ID del archivo de logo a la configuración
            $configuration->file_id = $file->id;
        }
    }

    // Guardar la configuración actualizada
    $configuration->save();

    // Redirigir con mensaje de éxito
    return redirect()->route('configuration.index')->with('success', 'Configuración actualizada correctamente.');
}







}
