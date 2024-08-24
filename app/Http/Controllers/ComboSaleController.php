<?php

namespace App\Http\Controllers;

use App\Models\ComboSale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ComboSaleController extends Controller
{
    public function index(Request $request)
    {
        $include = [];
        if ($request->query('includeCombo')) $include[] = 'combo';
        if ($request->query('includeSale')) $include[] = 'sale';

        return response()->json([
            "success" => true,
            "message" => "Recursos encontrados",
            "data" => ComboSale::with($include)->get()
        ]);
    }

    public function store(Request $request)
    {
        $includes = [];
        if ($request->query('includeCombo')) $include[] = 'combo';
        if ($request->query('includeSale')) $include[] = 'sale';

        $validator = Validator::make($request->all(),  [
            'quantity' => 'required|numeric',
            'price' => 'required|numeric',
            'sale_id' => 'required|exists:sale,id',
            'combo_id' => 'required|exists:combo,id',
        ], [
            'quantity.required' => 'El campo cantidad es requerido',
            'quantity.numeric' => 'El campo cantidad debe ser un número',
            'price.required' => 'El campo precio es requerido',
            'price.numeric' => 'El campo precio debe ser un número',
            'sale_id.required' => 'El campo venta es requerido',
            'sale_id.exists' => 'La venta no existe',
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

        $data = ComboSale::create($request->all());

        return response()->json([
            "success" => true,
            "message" => "Recurso creado",
            "errors" => null,
            "data" => $data->load($includes)
        ]);
    }

    public function show(Request $request, ComboSale $comboSale)
    {
        $includes = [];
        if ($request->query('includeCombo')) $include[] = 'combo';
        if ($request->query('includeSale')) $include[] = 'sale';

        return response()->json([
            "success" => true,
            "message" => "Recurso encontrado",
            "errors" => null,
            "data" => $comboSale->load($includes),
        ]);
    }

    public function update(Request $request, $id)
    {
        $includes = [];
        if ($request->query('includeProduct')) $include[] = 'product';
        if ($request->query('includeCombo')) $include[] = 'combo';

        $comboSale = ComboSale::find($id);
        if (!$comboSale) {
            return response()->json([
                "success" => false,
                "message" => "Recurso no encontrado",
                "data" => null
            ]);
        }

        $validator = Validator::make($request->all(),  [
            'quantity' => 'required|numeric',
            'price' => 'required|numeric',
            'sale_id' => 'required|exists:sale,id',
            'combo_id' => 'required|exists:combo,id',
        ], [
            'quantity.required' => 'El campo cantidad es requerido',
            'quantity.numeric' => 'El campo cantidad debe ser un número',
            'price.required' => 'El campo precio es requerido',
            'price.numeric' => 'El campo precio debe ser un número',
            'sale_id.required' => 'El campo venta es requerido',
            'sale_id.exists' => 'La venta no existe',
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

        $comboSale->update($request->all());

        return response()->json([
            "success" => true,
            "message" => "Recurso actualizado",
            "errors" => null,
            "data" => $comboSale->load($includes),
            "token" => null
        ]);
    }

    public function destroy(ComboSale $comboSale)
    {
        $comboSale->load(['sale', 'combo']);
        if ($comboSale->sale->count() > 0 || $comboSale->combo->count() > 0) {
            return response()->json([
                "success" => false,
                "message" => "No se puede eliminar el recurso, tiene otros recursos asociados",
                "data" => null
            ]);
        }


        $comboSale->delete();

        return response()->json([
            "success" => true,
            "message" => "Recurso eliminado",
            "errors" => null,
            "data" => $comboSale
        ]);
    }
}
