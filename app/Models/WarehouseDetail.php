<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WarehouseDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'quantity',
        'origin'
    ];

    public function warehouse()
    {
        return $this->hasOne(Warehouse::class);
    }

    public function product()
    {
        return $this->hasOne(Product::class);
    }
}