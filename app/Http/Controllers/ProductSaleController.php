<?php

namespace App\Http\Controllers;

use App\Models\ProductSale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductSaleController extends Controller
{
    public function index(Request $request)
    {
        $include = [];
        if ($request->query('includeProduct')) $include[] = 'product';
        if ($request->query('includeSale')) $include[] = 'sale';

        return response()->json([
            "success" => true,
            "message" => "Recursos encontrados",
            "data" => ProductSale::with($include)->get()
        ]);
    }

    public function store(Request $request)
    {
        $includes = [];
        if ($request->query('includeProduct')) $include[] = 'product';
        if ($request->query('includeSale')) $include[] = 'sale';

        $validator = Validator::make($request->all(),  [
            'quantity' => 'required|numeric',
            'price' => 'required|numeric',
            'product_id' => 'required|exists:product,id',
            'sale_id' => 'required|exists:sale,id',
        ], [
            'quantity.required' => 'El campo cantidad es requerido',
            'quantity.numeric' => 'El campo cantidad debe ser un número',
            'price.required' => 'El campo precio es requerido',
            'price.numeric' => 'El campo precio debe ser un número',
            'product_id.required' => 'El campo producto es requerido',
            'product_id.exists' => 'El producto no existe',
            'sale_id.required' => 'El campo venta es requerido',
            'sale_id.exists' => 'La venta no existe',
        ]);
        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "message" => $validator->errors()->first(),
                "errors" => $validator->errors(),
                "data" => null
            ]);
        }

        $data = ProductSale::create($request->all());

        return response()->json([
            "success" => true,
            "message" => "Recurso creado",
            "errors" => null,
            "data" => $data->load($includes)
        ]);
    }

    public function show(Request $request, ProductSale $productSale)
    {
        $includes = [];
        if ($request->query('includeProduct')) $include[] = 'product';
        if ($request->query('includeSale')) $include[] = 'sale';

        return response()->json([
            "success" => true,
            "message" => "Recurso encontrado",
            "errors" => null,
            "data" => $productSale->load($includes),
        ]);
    }

    public function update(Request $request, $id)
    {
        $includes = [];
        if ($request->query('includeProduct')) $include[] = 'product';
        if ($request->query('includeSale')) $include[] = 'sale';

        $productSale = ProductSale::find($id);
        if (!$productSale) {
            return response()->json([
                "success" => false,
                "message" => "Recurso no encontrado",
                "data" => null
            ]);
        }

        $validator = Validator::make($request->all(),  [
            'quantity' => 'required|numeric',
            'price' => 'required|numeric',
            'product_id' => 'required|exists:product,id',
            'sale_id' => 'required|exists:sale,id',
        ], [
            'quantity.required' => 'El campo cantidad es requerido',
            'quantity.numeric' => 'El campo cantidad debe ser un número',
            'price.required' => 'El campo precio es requerido',
            'price.numeric' => 'El campo precio debe ser un número',
            'product_id.required' => 'El campo producto es requerido',
            'product_id.exists' => 'El producto no existe',
            'sale_id.required' => 'El campo venta es requerido',
            'sale_id.exists' => 'La venta no existe',
        ]);

        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "message" => $validator->errors()->first(),
                "errors" => $validator->errors(),
                "data" => null
            ]);
        }

        $productSale->update($request->all());

        return response()->json([
            "success" => true,
            "message" => "Recurso actualizado",
            "errors" => null,
            "data" => $productSale->load($includes),
            "token" => null
        ]);
    }

    public function destroy(ProductSale $productSale)
    {
        $productSale->load(['product', 'sale']);
        if ($productSale->product->count() > 0 || $productSale->sale->count() > 0) {
            return response()->json([
                "success" => false,
                "message" => "No se puede eliminar el recurso, tiene otros recursos asociados",
                "data" => null
            ]);
        }


        $productSale->delete();

        return response()->json([
            "success" => true,
            "message" => "Recurso eliminado",
            "errors" => null,
            "data" => $productSale
        ]);
    }
}
