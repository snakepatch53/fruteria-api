<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComboSale extends Model
{
    use HasFactory;

    protected $fillable = [
        'quantity',
        'price',
        'combo_id',
        'sale_id',
    ];

    public function combo()
    {
        return $this->belongsTo(Combo::class);
    }

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }
}
