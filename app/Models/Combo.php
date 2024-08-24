<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Combo extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
    ];

    public function comboProducts()
    {
        return $this->hasMany(ComboProduct::class);
    }

    public function ComboSales()
    {
        return $this->hasMany(ComboSale::class);
    }
}
