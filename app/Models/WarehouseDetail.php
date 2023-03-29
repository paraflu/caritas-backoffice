<?php

namespace App\Models;

use App\Enums\ProductOriginEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class WarehouseDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'warehouse_id',
        'quantity',
        'origin',
        'product_id',
        'price'
    ];

    protected $casts = [
        'origin' => ProductOriginEnum::class,
    ];

    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
