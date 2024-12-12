<?php

namespace App\Http\Controllers;

use App\DataTables\AccessLogDataTable;
use App\DataTables\UsersDataTable;
use App\Events\UserUpdated;
use App\Models\AccessLog;
use App\Models\Configuration;
use App\Models\Employee;
use App\Models\File;
use Illuminate\Http\Request;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Http\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash as FacadesHash;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\QueryDataTable;

class UserController extends Controller
{
    public function updateProfileImage(Request $request)
    {
        // Validar que la imagen es correcta
        $request->validate([
            'profile_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();

        // Subir la nueva imagen de perfil
        if ($request->hasFile('profile_image')) {
            $imagePath = $request->file('profile_image')->store('profile_images', 'public');

            // Si el usuario ya tiene una imagen de perfil, elimina la anterior
            if ($user->profile_image) {
                Storage::disk('public')->delete($user->profile_image);
            }

            // Actualiza la imagen de perfil en la base de datos
            $user->profile_image = $imagePath;
            $user->save();
        }

        return response()->json(['message' => 'Imagen actualizada correctamente'], 200);
    }

   
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->editColumn('created_at', function (User $model) {
                return $model->created_at->format('d/m/Y H:i:s');
            })
            ->editColumn('updated_at', function (User $model) {
                return $model->updated_at->format('d/m/Y H:i:s');
            })
            ->addColumn('action', 'users.action')
            ->setRowId('id');
    }

    public function query(User $model): QueryBuilder
    {
        return $model->newQuery()->orderBy('id', 'asc');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(UsersDataTable $dataTable)
    {
        
        return $dataTable->render('users.index', [
            'total_users' => User::whereDoesntHave('roles', function ($query) {
                $query->where('name', 'client');
            })->count(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // No verificamos si está logueado
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $userData = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:8',
            'password_confirmation' => 'required|same:password', 
        ]);
    
        $userData['password'] = bcrypt($userData['password']);
    
        $role = $request->has('role') ? $request->role : 'client';
    
        $user = User::create($userData);
    
        $user->syncRoles([$role]);
    
        if ($role === 'client') {
            return redirect()->route('login');
        }
        
        return response()->json($user, 201);
    }
    


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user); 
    }

    public function profile(AccessLogDataTable $dataTable)
    {
        // Obtén el usuario autenticado
        $user = Auth::user();

        // Filtra los logs del usuario autenticado
        $logs = AccessLog::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();
        $lastLoginLog = AccessLog::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->first();

        // Devuelve la vista del perfil con los logs y el usuario
        return $dataTable->render('users.profile', compact('user', 'logs', 'lastLoginLog'));
    }

    public function showProfile()
    {
        $user = Auth::user(); // Obtenemos el usuario autenticado
        // Asegúrate de cargar la relación profileImage si es necesario
        $user->load('profileImage');

        return view('profile.show', [
            'user' => $user,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $usuario = User::findOrFail($id);
        return view('users.edit', ['usuario' => $usuario]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => $request->filled('password')? 'nullable|string|min:8|confirmed' : 'nullable',
            'role' => 'required|string'
        ]);

        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];

        // Solo actualiza la contraseña si se ha proporcionado
        if ($request->filled('password')) {
            $user->password = Hash::make($validatedData['password']);
        }
        $role = $request->role; 
        $user->syncRoles([$role]); 

        $user->save();

        // Dispara el evento después de guardar el usuario
        broadcast(new UserUpdated($user))->toOthers();

        return response()->json(['message' => 'Usuario actualizado correctamente.']);
    }


    // Ahora recibimos la solicitud para crear el empleado
    public function createEmployee(Request $request)
    {
        // Validación de los datos del empleado
        $employeeData = $request->validate([
            'position' => 'nullable|string',
            'department' => 'required|string',
            'status' => 'required|string',
            'company_id' => 'required|exists:companies,id',
            'user_id' => 'required|exists:users,id', // Asegúrate de que se pase el user_id
        ]);

        // Asignar valores por defecto si no se proporcionan
        $employeeData['position'] = $employeeData['position'] ?? 'Sin especificar';
        $employeeData['department'] = $employeeData['department'] ?? 'Sin especificar';
        $employeeData['status'] = $employeeData['status'] ?? 'Inactivo';

        // Crear el empleado
        $employee = Employee::create($employeeData);

        // Devolver la respuesta con los datos del empleado creado
        return response()->json(['message' => 'Usuario creado correctamente.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        User::destroy($id);
        return redirect()->route('users.index');
    }
    public function downloadUserProfile($id)
    {
        $user = User::findOrFail($id); // Obtener el usuario por su ID

        // Cargar la vista con los datos del usuario
        $pdf = Pdf::loadView('pdf.user_profile', compact('user'));

        // Descargar el PDF, usando el nombre del usuario en el archivo
        return $pdf->download('user_profile_' . $user->name . '.pdf');
    }
}
