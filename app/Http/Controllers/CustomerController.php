<?php


namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Warehouse;
use DataTables;
use Inertia\Inertia;
use Request;

class CustomerController extends Controller
{
    public function index()
    {
        return Inertia::render('Customer/Index');
    }

    public function pagedata()
    {
        return DataTables::of(Customer::query())->toJson();
    }

    public function pagedataByWarehouse(Request $request, Warehouse $warehouse)
    {
        $query = Customer::where('warehouse_id', $warehouse->id);
        return DataTables::of($query)->toJson();
    }
}
