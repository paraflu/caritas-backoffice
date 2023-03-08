<?php

namespace App\Http\Controllers;

use App\Models\Warehouse;
use Illuminate\Http\Request;

class WarehouseController extends Controller
{
    public function index(Request $request)
    {
        return view('warehouse.index');
    }

    public function pagedata() {
        $warehouse = Warehouse::select('month', 'year');
        return datatables($warehouse)->make();
    }

}
