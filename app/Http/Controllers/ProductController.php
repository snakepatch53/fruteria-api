<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    private $IMAGE_PATH = "public/product_img";
    private $IMAGE_TYPE = "jpg,jpeg,png";
    public function index(Request $request)
    {
        $include = [];
        if ($request->query('includeProductSales')) $include[] = 'productSales';
        if ($request->query('includeComboProducts')) $include[] = 'comboProducts';

        return response()->json([
            "success" => true,
            "message" => "Recursos encontrados",
            "data" => Product::with($include)->get()
        ]);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(),  [
            'name' => 'required|min:3',
            'image' => 'file|mimes:' . $this->IMAGE_TYPE,
            'price' => 'required|numeric',
            'sale_type' => 'required',
            'offer' => 'required|boolean',
            'active' => 'required|boolean',
        ], [
            'name.required' => 'El campo nombre es requerido',
            'name.min' => 'El campo nombre debe tener al menos 3 caracteres',
            'image.file' => 'El campo foto debe ser un archivo',
            'image.mimes' => 'El campo foto debe ser un archivo de tipo: ' . $this->IMAGE_TYPE,
            'price.required' => 'El campo precio es requerido',
            'price.numeric' => 'El campo precio debe ser un número',
            'sale_type.required' => 'El campo tipo de venta es requerido',
            'sale_type.exists' => 'El tipo de venta no existe',
            'offer.required' => 'El campo oferta es requerido',
            'active.required' => 'El campo activo es requerido',
        ]);
        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "message" => $validator->errors()->first(),
                "errors" => $validator->errors(),
                "data" => null
            ]);
        }


        if ($request->file("image")) {
            $fileName_photo = basename($request->file("image")->store($this->IMAGE_PATH));
            $request = new Request($request->except(["image"]) + ["image" => $fileName_photo]);
        }

        $data = Product::create($request->all());

        return response()->json([
            "success" => true,
            "message" => "Recurso creado",
            "errors" => null,
            "data" => $data
        ]);
    }

    public function show(Request $request, Product $product)
    {
        $includes = [];
        if ($request->query('includeProductSales')) $include[] = 'productSales';
        if ($request->query('includeComboProducts')) $include[] = 'comboProducts';

        return response()->json([
            "success" => true,
            "message" => "Recurso encontrado",
            "errors" => null,
            "data" => $product->load($includes),
        ]);
    }

    public function update(Request $request, $id)
    {
        $includes = [];
        if ($request->query('includeProductSales')) $include[] = 'productSales';
        if ($request->query('includeComboProducts')) $include[] = 'comboProducts';

        $product = Product::find($id);
        if (!$product) {
            return response()->json([
                "success" => false,
                "message" => "Recurso no encontrado",
                "data" => null
            ]);
        }

        $validator = Validator::make($request->all(),  [
            'name' => 'required|min:3',
            'image' => 'file|mimes:' . $this->IMAGE_TYPE,
            'price' => 'required|numeric',
            'sale_type' => 'required',
            'offer' => 'required|boolean',
            'active' => 'required|boolean',
        ], [
            'name.required' => 'El campo nombre es requerido',
            'name.min' => 'El campo nombre debe tener al menos 3 caracteres',
            'image.file' => 'El campo foto debe ser un archivo',
            'image.mimes' => 'El campo foto debe ser un archivo de tipo: ' . $this->IMAGE_TYPE,
            'price.required' => 'El campo precio es requerido',
            'price.numeric' => 'El campo precio debe ser un número',
            'sale_type.required' => 'El campo tipo de venta es requerido',
            'sale_type.exists' => 'El tipo de venta no existe',
            'offer.required' => 'El campo oferta es requerido',
            'active.required' => 'El campo activo es requerido',
        ]);

        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "message" => $validator->errors()->first(),
                "errors" => $validator->errors(),
                "data" => null
            ]);
        }

        if ($request->file("image")) {
            $fileName_photo = basename($request->file("image")->store($this->IMAGE_PATH));
            $request = new Request($request->except(["image"]) + ["image" => $fileName_photo]);
            if (Storage::exists($this->IMAGE_PATH . "/" . $product->photo)) Storage::delete($this->IMAGE_PATH . "/" . $product->image);
        }

        $product->update($request->all());

        return response()->json([
            "success" => true,
            "message" => "Recurso actualizado",
            "errors" => null,
            "data" => $product->load($includes),
            "token" => null
        ]);
    }

    public function destroy(Product $product)
    {
        $product->load(['productSales', 'comboProducts']);
        if ($product->productSales->count() > 0 || $product->comboProducts->count() > 0) {
            return response()->json([
                "success" => false,
                "message" => "No se puede eliminar el recurso, tiene otros recursos asociados",
                "data" => null
            ]);
        }

        // eliminamos tambien el archivo
        if (Storage::exists($this->IMAGE_PATH . "/" . $product->image)) Storage::delete($this->IMAGE_PATH . "/" . $product->image);

        $product->delete();

        return response()->json([
            "success" => true,
            "message" => "Recurso eliminado",
            "errors" => null,
            "data" => $product
        ]);
    }
}
