<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('warehouses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('month')->nullable(false);
            $table->integer('year')->nullable(false);
            $table->timestamps();
        });

        Schema::create('warehousedetails', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('warehouse_id')->costrained('warehouses');
            $table->foreignId('product_id')->costrained('products');
            $table->float('quantity')->nullable(false);
            $table->enum('origin', ['caritas', 'donation'])->default('caritas');
        });

        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('description')->nullable(false);
            $table->float('price')->nullable(false);
            $table->timestamps();
        });

        Schema::create('delivery', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreign('charity_id')->contained('charities');
            $table->foreignId('warehouse_id')->costrained('warehouses');
            $table->float('total')->nullable(false);
            $table->timestamps();
        });

        Schema::create('deliverydetails', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreign('delivery_id')->contained('deliveries');
            $table->foreign('product_id')->contained('products');
            $table->integer('quantity')->nullable(false);
            $table->float('price')->nullable(false);
            $table->float('total')->nullable(false);
            $table->timestamps();
        });

        Schema::create('charities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('firstname')->nullable(false);
            $table->string('secondname')->nullable(false);
            $table->unique(['firstname', 'secondname']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('warehoues');
        Schema::drop('warehousedetails');
    }
};