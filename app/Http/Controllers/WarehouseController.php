<?php

namespace App\Http\Controllers;

use App\Helpers\Icons;
use App\Models\Product;
use App\Models\Warehouse;
use App\Traits\HasActionColumn;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Redirect;
use DataTables;

class WarehouseController extends Controller
{
    use HasActionColumn;

    public function index(Request $request)
    {
        return Inertia::render('Warehouse/Index');
    }

    public function pagedata()
    {
        $warehouse = Warehouse::select('id', 'month', 'year');

        return DataTables::of($warehouse)
            ->addColumn('details', function ($row) {
                return [
                    'total' => $row->details->count(),
                    'cost' => $row->details->map(fn ($it) => $it['quantity'] * $it['price'])->sum(),
                    'group' => $row->details->groupBy('product_id')->map->sum('quantity')->map(fn ($it, $k) => [
                        "product_id" => $k, "count" => $it
                    ])->values()->toArray(),
                ];
            })
            ->addColumn('action', fn ($warehouse) => $this->buildActionColumns($warehouse, 'warehouse', function ($model) {
                return '<button class="ml-2 btn info" data-id="' . $model->id . '" data-action="detail" title="' . __('warehouse.details') . '"><div>' . Icons::detail() . '</div></button>';
            }))
            ->toJson();
    }


    public function create()
    {
        return Inertia::render('Warehouse/Create', [
            'allow_resume' => Warehouse::count() > 0,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'year' => "numeric|required|min:2021|max:" . now()->year + 2,
            'month' => 'numeric|required|between:1,12'
        ]);

        Warehouse::create($request->only('month', 'year'));
        return Redirect::route('warehouse.index');
    }

    public function edit(Request $request, Warehouse $warehouse)
    {
        return Inertia::render('Warehouse/Edit', ['data' => $warehouse]);
    }

    public function update(Request $request, Warehouse $warehouse)
    {
        $request->validate(
            [
                'id' => 'required|numeric|exists:warehouses',
                'month' => 'required|numeric|between:1,12',
                'year' => 'required|numeric|min:' . now()->subYears(1)->year . "|max:" . now()->year + 1
            ]
        );

        $warehouse->update($request->only('month', 'year'));
        return Redirect::route('warehouse.index');
    }

    public function destroy(Request $request, Warehouse $warehouse)
    {
        $warehouse->delete();
        return Redirect::route('warehouse.index');
    }

    public function detail(Warehouse $warehouse)
    {
        return Inertia::render('Warehouse/Detail', [
            'warehouse' => $warehouse,
            'warehouse_details' => $warehouse->details,
            'products' => Product::all()
        ]);
    }
}
