<?php

namespace App\Http\Controllers;


use App\Models\Configuration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ConfigurationController extends Controller
{

    public function index()
    {
        $configuration = Configuration::find(1);

        if (!$configuration) {
            // Maneja el caso donde la configuración no existe.
            return redirect()->back()->withErrors('No se encontró la configuración.');
        }

        return view('configuration.index', [
            'configuration' => $configuration,
        ]);
    }


    public function store(Request $request)
{

    $request->validate([
        'user_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);


    if ($request->hasFile('user_image')) {

        $image = $request->file('user_image');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        // $path = $image->storeAs('public/user_images', $imageName); // Aquí la imagen se guardará en storage/app/public/user_images
        $image->move(storage_path('app/public/user_images'), $imageName);

        // Verificamos si la imagen fue almacenada correctamente
        if (Storage::disk('public')->exists('user_images/' . $imageName)) {

            $configuration = Configuration::find(1);


            $configuration->user_image = 'user_images/' . $imageName;
            
            $configuration->save();


            return redirect()->route('configuration.index')
                             ->with('success', 'Imagen de usuario actualizada correctamente.');
        } else {
            return redirect()->route('configuration.index')
                             ->with('error', 'Hubo un error al guardar la imagen.');
        }
    } else {
        return redirect()->route('configuration.index')
                         ->with('error', 'No se ha enviado ninguna imagen.');
    }

}



}
