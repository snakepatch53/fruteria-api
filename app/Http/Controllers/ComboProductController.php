<?php

namespace App\Http\Controllers;

use App\Models\ComboProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ComboProductController extends Controller
{

    public function index(Request $request)
    {
        $include = [];
        if ($request->query('includeProduct')) $include[] = 'product';
        if ($request->query('includeCombo')) $include[] = 'combo';

        return response()->json([
            "success" => true,
            "message" => "Recursos encontrados",
            "data" => ComboProduct::with($include)->get()
        ]);
    }

    public function store(Request $request)
    {
        $includes = [];
        if ($request->query('includeProduct')) $include[] = 'product';
        if ($request->query('includeCombo')) $include[] = 'combo';

        $validator = Validator::make($request->all(),  [
            'quantity' => 'required|numeric',
            'price' => 'required|numeric',
            'product_id' => 'required|exists:products,id',
            'combo_id' => 'required|exists:combos,id',
        ], [
            'quantity.required' => 'El campo cantidad es requerido',
            'quantity.numeric' => 'El campo cantidad debe ser un número',
            'price.required' => 'El campo precio es requerido',
            'price.numeric' => 'El campo precio debe ser un número',
            'product_id.required' => 'El campo producto es requerido',
            'product_id.exists' => 'El producto no existe',
            'combo_id.required' => 'El campo combo es requerido',
            'combo_id.exists' => 'El combo no existe',
        ]);

        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "message" => $validator->errors()->first(),
                "errors" => $validator->errors(),
                "data" => null
            ]);
        }

        $data = ComboProduct::create($request->all());

        return response()->json([
            "success" => true,
            "message" => "Recurso creado",
            "errors" => null,
            "data" => $data->load($includes)
        ]);
    }

    public function show(Request $request, ComboProduct $comboProduct)
    {
        $includes = [];
        if ($request->query('includeProduct')) $include[] = 'product';
        if ($request->query('includeCombo')) $include[] = 'combo';

        return response()->json([
            "success" => true,
            "message" => "Recurso encontrado",
            "errors" => null,
            "data" => $comboProduct->load($includes),
        ]);
    }

    public function update(Request $request, $id)
    {
        $includes = [];
        if ($request->query('includeProduct')) $include[] = 'product';
        if ($request->query('includeCombo')) $include[] = 'combo';

        $comboProduct = ComboProduct::find($id);
        if (!$comboProduct) {
            return response()->json([
                "success" => false,
                "message" => "Recurso no encontrado",
                "data" => null
            ]);
        }

        $validator = Validator::make($request->all(),  [
            'quantity' => 'required|numeric',
            'price' => 'required|numeric',
            'product_id' => 'required|exists:products,id',
            'combo_id' => 'required|exists:combos,id',
        ], [
            'quantity.required' => 'El campo cantidad es requerido',
            'quantity.numeric' => 'El campo cantidad debe ser un número',
            'price.required' => 'El campo precio es requerido',
            'price.numeric' => 'El campo precio debe ser un número',
            'product_id.required' => 'El campo producto es requerido',
            'product_id.exists' => 'El producto no existe',
            'combo_id.required' => 'El campo combo es requerido',
            'combo_id.exists' => 'El combo no existe',
        ]);

        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "message" => $validator->errors()->first(),
                "errors" => $validator->errors(),
                "data" => null
            ]);
        }

        $comboProduct->update($request->all());

        return response()->json([
            "success" => true,
            "message" => "Recurso actualizado",
            "errors" => null,
            "data" => $comboProduct->load($includes),
            "token" => null
        ]);
    }

    public function destroy(ComboProduct $comboProduct)
    {
        $comboProduct->load(['product', 'combo']);
        if ($comboProduct->product->count() > 0 || $comboProduct->combo->count() > 0) {
            return response()->json([
                "success" => false,
                "message" => "No se puede eliminar el recurso, tiene otros recursos asociados",
                "data" => null
            ]);
        }


        $comboProduct->delete();

        return response()->json([
            "success" => true,
            "message" => "Recurso eliminado",
            "errors" => null,
            "data" => $comboProduct
        ]);
    }
}
