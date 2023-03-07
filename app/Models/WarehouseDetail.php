<?php

namespace App\Models;

use App\Enums\ProductOriginEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class WarehouseDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'quantity',
        'origin'
    ];

    protected $casts = [
        'origin' => ProductOriginEnum::class
    ];

    public function warehouse()
    {
        return $this->hasOne(Warehouse::class);
    }

    public function product(): HasOne
    {
        return $this->hasOne(Product::class);
    }
}