<?php

namespace App\Http\Controllers;

use App\Models\FoodParcel;
use App\Models\User;
use App\Traits\HasActionColumn;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Yajra\DataTables\Contracts\DataTable;
use Yajra\DataTables\Facades\DataTables;

class FoodParcelController extends Controller
{
    use HasActionColumn;

    public function Index()
    {
        return Inertia::render('FoodParcel/Index');
    }

    public function pagedata()
    {
        return DataTables::of(FoodParcel::query())
            ->toJson();
    }
}
