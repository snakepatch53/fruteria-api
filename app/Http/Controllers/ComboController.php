<?php

namespace App\Http\Controllers;

use App\Models\Combo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ComboController extends Controller
{
    public function index(Request $request)
    {
        $include = [];
        if ($request->query('includeComboSales')) $include[] = 'comboSales';
        if ($request->query('includeComboProducts')) $include[] = 'comboProducts.product';

        return response()->json([
            "success" => true,
            "message" => "Recursos encontrados",
            "data" => Combo::with($include)->get()
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),  [
            'name' => 'required|min:3',
            'price' => 'required|numeric',
        ], [
            'name.required' => 'El campo nombre es requerido',
            'name.min' => 'El campo nombre debe tener al menos 3 caracteres',
            'price.required' => 'El campo precio es requerido',
            'price.numeric' => 'El campo precio debe ser un número',
        ]);

        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "message" => $validator->errors()->first(),
                "errors" => $validator->errors(),
                "data" => null
            ]);
        }

        $includes = [];
        if ($request->query('includeComboSales')) $includes[] = 'comboSales';
        if ($request->query('includeComboProducts')) $includes[] = 'comboProducts.product';

        $data = Combo::create($request->all());

        return response()->json([
            "success" => true,
            "message" => "Recurso creado",
            "errors" => null,
            "data" => $data->load($includes)
        ]);
    }

    public function show(Request $request, Combo $combo)
    {
        $includes = [];
        if ($request->query('includeComboSales')) $includes[] = 'comboSales';
        if ($request->query('includeComboProducts')) $includes[] = 'comboProducts.product';

        return response()->json([
            "success" => true,
            "message" => "Recurso encontrado",
            "errors" => null,
            "data" => $combo->load($includes)
        ]);
    }

    public function update(Request $request, Combo $combo)
    {
        $validator = Validator::make($request->all(),  [
            'name' => 'required|min:3',
            'price' => 'required|numeric',
            'active' => 'boolean',
        ], [
            'name.required' => 'El campo nombre es requerido',
            'name.min' => 'El campo nombre debe tener al menos 3 caracteres',
            'price.required' => 'El campo precio es requerido',
            'price.numeric' => 'El campo precio debe ser un número',
            'active.boolean' => 'El campo activo debe ser un booleano',

        ]);

        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "message" => $validator->errors()->first(),
                "errors" => $validator->errors(),
                "data" => null
            ]);
        }

        $combo->update($request->all());

        return response()->json([
            "success" => true,
            "message" => "Recurso actualizado",
            "errors" => null,
            "data" => $combo,
            "token" => null
        ]);
    }

    public function destroy(Combo $combo)
    {
        $combo->load(['comboSales']);
        if ($combo->ComboSales->count() > 0) {
            return response()->json([
                "success" => false,
                "message" => "No se puede eliminar el recurso, tiene otros recursos asociados",
                "data" => null
            ]);
        }


        $combo->delete();

        return response()->json([
            "success" => true,
            "message" => "Recurso eliminado",
            "errors" => null,
            "data" => $combo
        ]);
    }
}
