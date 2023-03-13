<?php

namespace App\Http\Controllers;

use App\Helpers\Icons;
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
        $warehouse = Warehouse::select('month', 'year');

        return DataTables::of($warehouse)
            ->addColumn('action', fn ($warehouse) => $this->buildActionColumns($warehouse, 'warehouse'))
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
}
