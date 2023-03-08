<?php

namespace App\Http\Controllers;

use App\Models\Warehouse;
use Illuminate\Http\Request;
use Inertia\Inertia;

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
        return Inertia::rendere('Warehouse/Create');
    }
}
