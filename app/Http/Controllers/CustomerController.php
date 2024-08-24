<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $include = [];
        if ($request->query('includeSales')) $include[] = 'sales';

        return response()->json([
            "success" => true,
            "message" => "Recursos encontrados",
            "data" => Customer::with($include)->get()
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),  [
            'cedula' => 'required|numeric',
            'name' => "required|min:3",
        ], [
            'cedula.required' => 'El campo cedula es requerido',
            'cedula.numeric' => 'El campo cedula debe ser un número',
            "name.required" => "El campo nombre es requerido",
            "name.min" => "El campo nombre debe tener al menos 3 caracteres",
        ]);

        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "message" => $validator->errors()->first(),
                "errors" => $validator->errors(),
                "data" => null
            ]);
        }

        $data = Customer::create($request->all());

        return response()->json([
            "success" => true,
            "message" => "Recurso creado",
            "errors" => null,
            "data" => $data
        ]);
    }

    public function show(Request $request, Customer $customer)
    {
        $includes = [];
        if ($request->query('includeSales')) $include[] = 'sales';

        return response()->json([
            "success" => true,
            "message" => "Recurso encontrado",
            "errors" => null,
            "data" => $customer->load($includes),
        ]);
    }

    public function update(Request $request, $id)
    {
        $customer = Customer::find($id);
        if (!$customer) {
            return response()->json([
                "success" => false,
                "message" => "Recurso no encontrado",
                "data" => null
            ]);
        }

        $validator = Validator::make($request->all(),  [
            'cedula' => 'required|numeric',
            'name' => "required|min:3",
        ], [
            'cedula.required' => 'El campo cedula es requerido',
            'cedula.numeric' => 'El campo cedula debe ser un número',
            "name.required" => "El campo nombre es requerido",
            "name.min" => "El campo nombre debe tener al menos 3 caracteres",

        ]);

        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "message" => $validator->errors()->first(),
                "errors" => $validator->errors(),
                "data" => null
            ]);
        }

        $customer->update($request->all());

        return response()->json([
            "success" => true,
            "message" => "Recurso actualizado",
            "errors" => null,
            "data" => $customer,
            "token" => null
        ]);
    }

    public function destroy(Customer $customer)
    {
        $customer->load(['sales']);
        if ($customer->sales->count() > 0) {
            return response()->json([
                "success" => false,
                "message" => "No se puede eliminar el recurso, tiene otros recursos asociados",
                "data" => null
            ]);
        }


        $customer->delete();

        return response()->json([
            "success" => true,
            "message" => "Recurso eliminado",
            "errors" => null,
            "data" => $customer
        ]);
    }
}
