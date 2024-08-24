<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'total'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function productSales()
    {
        return $this->hasMany(ProductSale::class);
    }

    public function comboSales()
    {
        return $this->hasMany(ComboSale::class);
    }
}
