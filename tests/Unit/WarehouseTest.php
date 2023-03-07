<?php

namespace Tests\Unit;

use App\Models\Product;
use App\Models\Warehouse;
use App\Models\WarehouseDetail;
use Database\Factories\ProductFactory;
use Tests\TestCase;

class WarehouseTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_crete_record(): void
    {
        $wh = Warehouse::factory()->create();

        $products = Product::factory()->count(3)->create();
        foreach ($products as $value) {
            /** @type WarehouseDetail */
            $detail = WarehouseDetail::factory()->make();
            $detail->product_id = $value->id;
            $wh->details()->save($detail);
        }

        $this->assertEquals(3, $wh->details->count());

    }
    
}