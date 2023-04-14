<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class FoodParcelDetail extends Model
{
    public $fillable = [
        'id'
    ];

    public function foodParcelDetails(): HasOne
    {
        return $this->hasOne(FoodParcel::class);
    }
}
