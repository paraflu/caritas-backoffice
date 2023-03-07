<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WarehouseController extends Controller
{
    public function index(Request $request)
    {
        return view('warehouse.index');
    }

    public function pagedata() {
        return datatables($warehouse)->make();
    }

}