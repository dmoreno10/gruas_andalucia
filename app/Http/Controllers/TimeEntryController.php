<?php

namespace App\Http\Controllers;

use App\DataTables\TimeEntryDataTable;
use App\Models\TimeEntry;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Asegúrate de importar la clase Auth
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TimeEntryController extends Controller
{
    public function getData()
    {
        try {
            // Selecciona solo las columnas que necesitas
            $entries = TimeEntry::select('id', 'employee_id', 'start_time', 'ended_at', 'created_at', 'updated_at', 'user_id')
                ->get();
            return response()->json($entries);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Server error'], 500);
        }
    }

    public function index(TimeEntryDataTable $dataTable)
    {

        return $dataTable->render('time-entries.index'); // Asegúrate de tener una vista en resources/views/time-entries/index.blade.php

    }

    public function start(Request $request)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $employee_id = 1;

            Log::info('Información recibida del frontend:', $request->all());

            $timeEntry = TimeEntry::create([
                'user_id' => $user->id,
                'employee_id' => $employee_id,
                'start_time' =>  Carbon::now('Europe/Madrid'),
                'ended_at' => null,
            ]);
            Log::info('Start-time al principio: '. $timeEntry->start_time);

            return response()->json(['message' => 'Jornada iniciada con éxito.', 'data' => $timeEntry], 201);
        }

        return response()->json(['message' => 'No autenticado'], 401);
    }


    public function end(Request $request)
    {
        // Verificar si el usuario está autenticado
        if (Auth::check()) {
            $user = Auth::user();
            $employee_id = 1; // Suponiendo que el ID del empleado es estático

            Log::info('Información recibida del frontend para terminar jornada:', $request->all());

            // Buscar la entrada de tiempo activa para el usuario y empleado
            $timeEntry = TimeEntry::where('user_id', $user->id)
                ->where('employee_id', $employee_id)
                ->whereNull('ended_at') // Solo busca entradas que no han sido terminadas
                ->first();

            // Si no se encuentra una jornada activa, se retorna un error
            if (!$timeEntry) {
                return response()->json(['message' => 'No hay una jornada activa para terminar.'], 404);
            }

            // Limpiar el valor recibido de 'ended_at' (si es necesario)
            $endedAtString = $request->input('ended_at');
            $endedAtString = str_replace(',', '', $endedAtString); // Limpiar la coma si existe

            // Log para verificar el valor de 'ended_at' recibido
            Log::info('Valor de ended_at recibido desde frontend: ' . $endedAtString);

            // Asegurarse de que el valor de 'ended_at' se maneje correctamente
            try {
                $endedAt = Carbon::createFromFormat('d/m/Y H:i:s', $endedAtString)
                    ->setTimezone('Europe/Madrid');
            } catch (\Exception $e) {
                try {
                    // Si falla el primer intento, intenta con el formato ISO
                    $endedAt = Carbon::parse($endedAtString)->setTimezone('Europe/Madrid');
                } catch (\Exception $e) {
                    Log::error('Error al parsear la fecha de ended_at: ' . $e->getMessage());
                    return response()->json(['message' => 'Formato de fecha inválido'], 400);
                }
            }

            // Log para verificar la fecha convertida a la zona horaria
            Log::info('Fecha convertida (zona horaria Europe/Madrid): ' . $endedAt);

            // Aquí solo actualizamos 'ended_at', nunca 'start_time'
            $timeEntry->ended_at = $endedAt;
            $timeEntry->save();

            // Log para verificar el valor de 'ended_at' después de actualizar la base de datos
            Log::info('Jornada terminada, ended_at guardado: ' . $timeEntry->ended_at);
            Log::info('start_time sigue siendo: ' . $timeEntry->start_time);

            // Devolver la respuesta
            return response()->json([
                'message' => 'Jornada terminada con éxito.',
                'data' => $timeEntry
            ], 200);
        }

        // Si no está autenticado, retornar un error
        return response()->json(['message' => 'No autenticado'], 401);
    }







public function getEntries() {
    if (Auth::check()) {
        $user = Auth::user();
        $employee_id = 1;

        $entries = TimeEntry::where('user_id', $user->id)
            ->where('employee_id', $employee_id)
            ->get();

        // foreach ($entries as $entry) {
        //     // $startTime = \Carbon\Carbon::parse($entry->start_time);
        //     $endTime = $entry->ended_at ? \Carbon\Carbon::parse($entry->ended_at) : null;

        //     // Calcular la duración solo si endTime es válido
        //     if ($endTime && $endTime->greaterThan($startTime)) {
        //         $entry->duration = $startTime->diffInSeconds($endTime);
        //     } else {
        //         $entry->duration = 0; // O null, dependiendo de cómo desees manejarlo
        //     }

        //     // Formatear duración
        //     $entry->formatted_duration = gmdate("H:i:s", $entry->duration);
        // }

        return response()->json(['entries' => $entries]);
    }

    return response()->json(['message' => 'No autenticado'], 401);
}
public function show($id)
{
    $entry = TimeEntry::findOrFail($id);
    return view('time-entries.show', compact('entry'));
}



}
