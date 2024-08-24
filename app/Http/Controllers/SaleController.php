<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SaleController extends Controller
{
    public function index(Request $request)
    {
        $include = [];
        if ($request->query('includeCustomer')) $include[] = 'customer';
        if ($request->query('includeProductSales')) $include[] = 'productSales';
        if ($request->query('includeComboSales')) $include[] = 'comboSales';


        return response()->json([
            "success" => true,
            "message" => "Recursos encontrados",
            "data" => Sale::with($include)->get()
        ]);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(),  [
            'total' => 'required|numeric',
            'customer_id' => 'required|exists:customer,id',
        ], [
            'total.required' => 'El campo total es requerido',
            'total.numeric' => 'El campo total debe ser un número',
            'customer_id.required' => 'El campo id del comprador es requerido',
            'customer_id.exists' => 'El comprador no existe',
        ]);
        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "message" => $validator->errors()->first(),
                "errors" => $validator->errors(),
                "data" => null
            ]);
        }

        $data = Sale::create($request->all());

        return response()->json([
            "success" => true,
            "message" => "Recurso creado",
            "errors" => null,
            "data" => $data
        ]);
    }

    public function show(Sale $sale)
    {
        //
    }

    public function update(Request $request, Sale $sale)
    {
        //
    }

    public function destroy(Sale $sale)
    {
        //
    }
}
