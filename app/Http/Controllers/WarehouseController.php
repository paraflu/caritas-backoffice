<?php

namespace App\Http\Controllers;

use App\Models\Warehouse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Redirect;

class WarehouseController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render('Warehouse/Index');
    }

    public function pagedata()
    {
        $warehouse = Warehouse::select('month', 'year');

        return datatables($warehouse)->make();
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
            'year'=> "numeric|required|min:2021|max:" . now()->year + 2,
            'month'=>'numeric|required|between:1,12'
        ]);

        Warehouse::create($request->only('month', 'year'));
        return Redirect::route('warehouse.index');
    }
}
