<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Client\Request;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function index()
    {
        return Inertia::render('Products/Index');
    }

    public function pagedata()
    {
        $products = Product::select('id', 'description', 'price');
        return datatables($products)->make(true);
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
    }
}
