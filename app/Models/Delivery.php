<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Delivery extends Model
{
    use HasFactory;
    protected $fillable = [
        'total'
    ];

    public function warehouse(): HasOne
    {
        return $this->hasOne(Warehouse::class);
    }

    public function details(): HasMany
    {
        return $this->hasMany(DeliveryDetail::class);
    }

    public function save(array $options = array()): bool
    {
        $this->total = $this->details()->reduce(function ($acc, $it) {
            return $acc + $it->total;
        });
        return parent::save($options);
    }
}