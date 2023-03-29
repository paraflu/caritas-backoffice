<?php

namespace App\Http\Controllers;

use App\Helpers\Icons;
use App\Models\Warehouse;
use App\Models\WarehouseDetail;
use App\Traits\HasActionColumn;
use DataTables;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class WarehouseDetailController extends Controller
{

    use HasActionColumn;

    public function index(Request $request, Warehouse $warehouse)
    {
        if ($request->ajax()) {
            $query = WarehouseDetail::with(['product'])->where('warehouse_id', $warehouse->id);
            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('action', fn ($model) => $this->buildActionColumns($model, 'warehouse.detail', noinsert: true))
                ->toJson();
        }
    }
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
        WarehouseDetail::where('warehouse_id', $warehouse_id)
            ->whereIn('product_id', collect($data['details'])->pluck('product_id'))
            ->delete();

        foreach ($data['details'] as $detail) {
            WarehouseDetail::create([
                'warehouse_id' => $warehouse_id,
                'product_id' => $detail['product_id'],
                'price' => $detail['price'],
                'quantity' => $detail['quantity'],
                'origin' => $detail['origin']
            ]);
        }
        return Redirect::back();
    }

    public function destroy(Request $request, WarehouseDetail $warehouseDetail)
    {
        $warehouseDetail->delete();
        return $request->ajax() ? response()->json(['success' => true]) : Redirect::route('warehouse_detail.index');
    }
}
