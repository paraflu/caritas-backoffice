<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductCreateRequest;
use App\Models\Product;
use Auth;
use Illuminate\Http\Client\Request;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function index()
    {
        return Inertia::render('Products/Index', ['canCreate' => Auth::user()->can('edit product')]);
    }

    public function pagedata()
    {
        $products = Product::select('id', 'description', 'price');
        return datatables($products)->make(true);
    }

    public function create()
    {
        return Inertia::render('Products/Create');
    }

    public function store(ProductCreateRequest $request)
    {
        Product::create($request->only('description', 'price'));
        return redirect(route('product.index'));
    }
}
