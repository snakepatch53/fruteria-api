<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{


    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required'
        ], [
            'email.required' => 'El campo email es requerido',
            'password.required' => 'El campo password es requerido'
        ]);

        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "message" => $validator->errors()->first(),
                "errors" => $validator->errors()
            ], 422);
        }

        if (!Auth::attempt($request->all())) {
            return response()->json([
                "success" => false,
                "message" => "Credenciales incorrectas",
                "errors" => null,
                "data" => null
            ], 401);
        }

        $user = User::where('email', $request->email)->first();
        $token = $user->createToken('authToken')->plainTextToken;
        $user->token = $token;

        return response()->json([
            "success" => true,
            "message" => "Inicio de sesión exitoso",
            "errors" => null,
            "data" => $user,
            "token" => $token
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            "success" => true,
            "message" => "Sesión cerrada",
            "errors" => null,
            "data" => null
        ]);
    }

    public function existSession()
    {
        $id = Auth::id();
        $user = User::find($id);
        if (!$user) {
            return response()->json([
                "success" => false,
                "message" => "No hay sesión iniciada",
                "errors" => null,
                "data" => null
            ]);
        }
        return response()->json([
            "success" => true,
            "message" => "Sesión iniciada",
            "errors" => null,
            "data" => $user
        ]);
    }

    public function index()
    {
        return response()->json([
            "success" => true,
            "message" => "Recursos encontrados",
            "data" => User::all()
        ]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),  [
            "name" => "required|min:3|max:150",
            "email" => "required|email|unique:users,email",
            "password" => "required|min:8"
        ], [
            "name.required" => "El campo nombre es requerido",
            "name.min" => "El campo nombre debe tener al menos 3 caracteres",
            "name.max" => "El campo nombre debe tener como máximo 150 caracteres",
            "email.required" => "El campo email es requerido",
            "email.email" => "El campo email debe ser un correo electrónico válido",
            "email.unique" => "El campo email ya está en uso",
            "password.required" => "El campo password es requerido",
            "password.min" => "El campo password debe tener al menos 8 caracteres"
        ]);

        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "message" => $validator->errors()->first(),
                "errors" => $validator->errors(),
                "data" => null
            ]);
        }

        if ($request->password) $request->merge(["password" => Hash::make($request->password)]);

        $request->merge(["confirmation_code" => md5($request->email)]);

        $data = User::create($request->all());

        $token = $data->createToken('authToken')->plainTextToken;
        $data->token = $token;

        return response()->json([
            "success" => true,
            "message" => "Recurso creado",
            "errors" => null,
            "data" => $data,
            "token" => $token,
        ]);
    }

    public function show(Request $request, User $user)
    {
        return response()->json([
            "success" => true,
            "message" => "Recurso encontrado",
            "errors" => null,
            "data" => $user
        ]);
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json([
                "success" => false,
                "message" => "Recurso no encontrado",
                "data" => null
            ]);
        }

        $validator = Validator::make($request->all(),  [
            "name" => "required|min:3|max:150",
            "email" => "required|email|unique:users,email," . $id
        ], [
            "name.required" => "El campo nombre es requerido",
            "name.min" => "El campo nombre debe tener al menos 3 caracteres",
            "name.max" => "El campo nombre debe tener como máximo 150 caracteres",
            "email.required" => "El campo email es requerido",
            "email.email" => "El campo email debe ser un correo electrónico válido",
            "email.unique" => "El campo email ya está en uso"
        ]);

        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "message" => $validator->errors()->first(),
                "errors" => $validator->errors(),
                "data" => $request->all()
            ]);
        }

        if ($request->password) $request->merge(["password" => Hash::make($request->password)]);

        $user->update($request->all());

        return response()->json([
            "success" => true,
            "message" => "Recurso actualizado",
            "errors" => null,
            "data" => $user,
            "token" => null
        ]);
    }

    public function destroy(User $user)
    {
        // $user->load(['businesses', 'carts']);
        // if ($user->businesses->count() > 0 || $user->carts->count() > 0) { //tiene registros asociados ?
        //     return response()->json([
        //         "success" => false,
        //         "message" => "No se puede eliminar el recurso, tiene otros recursos asociados",
        //         "data" => null
        //     ]);
        // }

        $user->delete();

        return response()->json([
            "success" => true,
            "message" => "Recurso eliminado",
            "errors" => null,
            "data" => $user
        ]);
    }
}
