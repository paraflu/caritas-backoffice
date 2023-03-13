<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductCreateRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Http\Requests\ProductDeleteRequest;
use App\Models\Product;
use Auth;
use Illuminate\Http\Client\Request;
use Inertia\Inertia;
use DataTables;
use App\Helpers\Icons;
use App\Traits\HasActionColumn;

class ProductController extends Controller
{
    use HasActionColumn;

    public function index()
    {
        return Inertia::render('Products/Index', ['canCreate' => Auth::user()->can('edit product')]);
    }

    public function pagedata()
    {
        $products = Product::select('id', 'description', 'price');
        return DataTables::of($products)
            ->addColumn('action', fn ($product) => $this->buildActionColumns($product, 'product'))
            ->toJson();
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

    public function edit(Product $product)
    {
        return Inertia::render('Products/Edit', ['product' => $product]);
    }

    public function update(Product $product, ProductUpdateRequest $request)
    {
        $product->update($request->only('description', 'price'));
        return redirect(route('product.index'));
    }

    public function delete(Product $product, ProductDeleteRequest $request)
    {
        return Inertia::render('Products/Delete', compact('product'));
    }

    public function destroy(Product $product, ProductDeleteRequest $request)
    {
        $product->delete();
        return redirect(route('product.index'));
    }
}
