<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    public $fillable = [
        'id',
        'name',
    ];

    public function foodparcel(): HasMany
    {
        return $this->hasMany(FoodParcel::class);
    }
}
