<?php

use App\Http\Controllers\FoodParcelController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\WarehouseDetailController;
use App\Http\Controllers\CustomerController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::prefix('/users')
    ->middleware(['auth', 'verified'])
    ->name('users.')
    ->group(function () {
        Route::get('', [UserController::class, 'index'])->name('index');
        Route::get('create', [UserController::class, 'create'])->name('create');
        Route::post('store', [UserController::class, 'store'])->name('store');
        Route::get('{user}', [UserController::class, 'edit'])->name('edit');
        Route::post('pagedata', [UserController::class, 'pagedata'])->name('pagedata');
        Route::put('update/{user}', [UserController::class, 'update'])->name('update');
        Route::delete('{user}', [UserController::class, 'destroy'])->name('destroy');
    });

Route::prefix('/warehouse_details')
    ->middleware(['auth', 'verified'])
    ->name('warehouse.detail.')
    ->group(function () {
        Route::post('/create', [WarehouseDetailController::class, 'store'])->name('store');
        Route::delete('/delete/{warehouse_detail}', [WarehouseDetailController::class, 'destroy'])->name('destroy');
        Route::post('/{warehouse}', [WarehouseDetailController::class, 'index'])->name('index');
    });

Route::prefix('/foodparcels')
    ->middleware(['auth', 'verified'])
    ->name('foodparcel.')
    ->group(function () {
        Route::get('', [FoodParcelController::class, 'index'])->name('index');
        Route::post('pagedata', [FoodParcelController::class, 'pagedata'])->name('pagedata');
    });

Route::prefix('/customers')
    ->middleware(['auth', 'verified'])
    ->name('customer.')
    ->group(function () {
        Route::get('', [CustomerController::class, 'index'])->name('index');
        Route::post('pagedata/', [CustomerController::class, 'pagedata'])->name('pagedata');
        Route::post('pagedata/{warehouse}', [CustomerController::class, 'pagedataByWarehouse'])->name('pagedataByWarehouse');
    });

Route::prefix('/warehouses')
    ->middleware(['auth', 'verified'])->name('warehouse.')
    ->group(function () {
        Route::get('/', [WarehouseController::class, 'index'])->name('index');
        Route::post('/pagedata', [WarehouseController::class, 'pagedata'])->name('pagedata');
        Route::get('/create', [WarehouseController::class, 'create'])->name('create');
        Route::post('/create', [WarehouseController::class, 'store'])->name('store');
        Route::get('/edit/{warehouse}', [WarehouseController::class, 'edit'])->name('edit');
        Route::get('/detail/{warehouse}', [WarehouseController::class, 'detail'])->name('detail');
        Route::put('/edit/{warehouse}', [WarehouseController::class, 'update'])->name('update');
        Route::delete('/delete/{warehouse}', [WarehouseController::class, 'destroy'])->name('destroy');
    });

Route::prefix('/products')
    ->middleware(['auth', 'verified'])->name('product.')
    ->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('index');
        Route::post('/pagedata', [ProductController::class, 'pagedata'])->name('pagedata');
        Route::get('/create', [ProductController::class, 'create'])->name('create');
        Route::post('/create', [ProductController::class, 'store'])->name('store');
        Route::get('/edit/{product}', [ProductController::class, 'edit'])->name('edit');
        Route::put('/edit/{product}', [ProductController::class, 'update'])->name('update');
        Route::delete('/delete/{product}', [ProductController::class, 'destroy'])->name('destroy');
    });

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



require __DIR__ . '/auth.php';
