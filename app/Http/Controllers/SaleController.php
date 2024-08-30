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
            'customer_id' => 'required|exists:customers,id',

            'product_sales.*.quantity' => 'required|numeric',
            'product_sales.*.price' => 'required|numeric',
            'product_sales.*.product_id' => 'required|exists:products,id',

            'combo_sales.*.quantity' => 'required|numeric',
            'combo_sales.*.price' => 'required|numeric',
            'combo_sales.*.combo_id' => 'required|exists:combos,id',
        ], [
            'total.required' => 'El campo total es requerido',
            'total.numeric' => 'El campo total debe ser un número',
            'customer_id.required' => 'El campo id del comprador es requerido',
            'customer_id.exists' => 'El comprador no existe',

            'product_sales.*.quantity.required' => 'El campo cantidad es requerido',
            'product_sales.*.quantity.numeric' => 'El campo cantidad debe ser un número',
            'product_sales.*.price.required' => 'El campo precio es requerido',
            'product_sales.*.price.numeric' => 'El campo precio debe ser un número',
            'product_sales.*.product_id.required' => 'El campo producto es requerido',
            'product_sales.*.product_id.exists' => 'El producto no existe',

            'combo_sales.*.quantity.required' => 'El campo cantidad es requerido',
            'combo_sales.*.quantity.numeric' => 'El campo cantidad debe ser un número',
            'combo_sales.*.price.required' => 'El campo precio es requerido',
            'combo_sales.*.price.numeric' => 'El campo precio debe ser un número',
            'combo_sales.*.combo_id.required' => 'El campo combo es requerido',
            'combo_sales.*.combo_id.exists' => 'El combo no existe',

        ]);
        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "message" => $validator->errors()->first(),
                "errors" => $validator->errors(),
                "data" => null
            ]);
        }

        // bulk insert
        $total = 0;
        if ($request->product_sales) {
            foreach ($request->product_sales as $product_sale) {
                $total += $product_sale['quantity'] * $product_sale['price'];
            }
        }
        if ($request->combo_sales) {
            foreach ($request->combo_sales as $combo_sale) {
                $total += $combo_sale['quantity'] * $combo_sale['price'];
            }
        }
        $data = Sale::create($request->all() + ['total' => $total]);
        if ($request->product_sales) $data->productSales()->createMany($request->product_sales);
        if ($request->combo_sales) $data->comboSales()->createMany($request->combo_sales);

        return response()->json([
            "success" => true,
            "message" => "Recurso creado",
            "errors" => null,
            "data" => $data
        ]);
    }

    public function show(Sale $sale, Request $request)
    {
        $include = [];
        if ($request->query('includeCustomer')) $include[] = 'customer';
        if ($request->query('includeProductSales')) $include[] = 'productSales.product';
        if ($request->query('includeComboSales')) $include[] = 'comboSales.combo';

        return response()->json([
            "success" => true,
            "message" => "Recurso encontrado",
            "data" => $sale->load($include)
        ]);
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
