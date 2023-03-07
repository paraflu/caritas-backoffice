<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class DeliveryDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'quantity',
        'price',
        'origin',
        'total',
    ];
    protected $casts = [
        'origin' => ProductOriginEnum::class
    ];

    public function delivery(): HasOne
    {
        return $this->hasOne(Delivery::class);
    }

    public function save(array $options = array()): bool
    {
        $this->total = $this->price * $this->quantity;
        return parent::save($options);
    }
}