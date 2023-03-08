<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Delivery extends Model
{
    use HasFactory;

    protected $hidden = ['total'];

    public function charity(): HasOne
    {
        return $this->hasOne(Charity::class);
    }

    public function warehouse(): HasOne
    {
        return $this->hasOne(Warehouse::class);
    }

    public function details(): HasMany
    {
        return $this->hasMany(DeliveryDetail::class);
    }

    public function save(array $options = []): bool
    {
        $this->total = $this->details->reduce(function ($acc, $it) {
            return $acc + $it->total;
        }, 0);

        return parent::save($options);
    }

    public function total(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value, array $attributes) => $this->details->reduce(function ($acc, $it) {
                return $acc + $it->total;
            }, 0),
            set: fn ($value) => $attributes['total'] = $value,
        );
    }
}
