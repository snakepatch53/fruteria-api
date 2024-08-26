<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public static $_SALE_TYPE = [
        "libras" => "Libras",
        "kilos" => "Kilos",
        "unidades" => "Unidades",
    ];

    public static $_CATEGORY = [
        "frutas" => "Frutas",
        "verduras" => "Verduras",
    ];

    protected $fillable = [
        'name',
        'description',
        'price',
        'image',
        'category',
        'sale_type',
        'offer',
        'active'
    ];

    protected $appends = [
        'image_url'
    ];

    public function getImageUrlAttribute()
    {
        if ($this->image == null) return asset("storage/app/public/img/product.png");
        return asset("storage/app/public/product_img/" . $this->image);
    }

    public function comboProducts()
    {
        return $this->hasMany(ComboProduct::class);
    }

    public function productSales()
    {
        return $this->hasMany(ProductSale::class);
    }
}
