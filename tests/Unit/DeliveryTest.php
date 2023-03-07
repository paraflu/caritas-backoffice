<?php

namespace Tests\Unit;

use App\Models\Charity;
use App\Models\Delivery;
use App\Models\DeliveryDetail;
use App\Models\Product;
use App\Models\Warehouse;
use App\Models\WarehouseDetail;
use Database\Factories\ProductFactory;
use Tests\TestCase;

class DeliveryTest extends TestCase
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

        $charity = Charity::factory()->create();

        $delivery = Delivery::factory()->create(['charity_id' => $charity->id]);

        $products = Product::factory(3)->create();

        foreach ($products as $key => $value) {
            DeliveryDetail::factory()->create([
                'product_id' => $value->id,
                'delivery_id' => $delivery->id
            ]);
        }

        $this->assertNotEquals(0, $delivery->total);

        $delivery->save();

        $this->assertNotEquals(0, $delivery->total);

        $delivery->details()->delete();
        $delivery->delete();

    }

}