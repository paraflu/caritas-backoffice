<?php

namespace App\Http\Controllers;


use App\Models\WarehouseDetail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class WarehouseDetailController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'warehouse_id' => 'required|exists:warehouses,id',
            'detail.*.product_id' => 'required|exists:products',
            'detail.*.origin' => 'required|in:donation,caritas',
            'detail.*.quantity' => 'required|numeric|min:0',
            'detail.*.price' => 'required|numeric|min:0'
        ]);

        $warehouse_id = $request->warehouse_id;

        $data = $request->only('details');

        // faccio pulizia prima
        WarehouseDetail::where('warehouse_id', $warehouse_id)->delete();

        foreach ($data['details'] as $detail) {
            WarehouseDetail::create([
                'warehouse_id' => $warehouse_id,
                'product_id' => $detail['product_id'],
                'price' => $detail['price'],
                'quantity' => $detail['quantity'],
                'origin' => $detail['origin']
            ]);
        }
        return Redirect::route('warehouse.index');
    }
}