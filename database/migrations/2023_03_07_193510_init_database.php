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

        Schema::create('warehouse_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('warehouse_id')->costrained('warehouses');
            $table->foreignId('product_id')->costrained('products');
            $table->float('quantity')->nullable(false);
            $table->float('price')->nullable(false);
            $table->enum('origin', ['caritas', 'donation'])->default('caritas');
            $table->timestamps();

        });

        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('description')->nullable(false);
            $table->float('price')->nullable(false);
            $table->timestamps();
        });

        Schema::create('deliveries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('charity_id')->costrained('charities');
            $table->float('total')->nullable(false);
            $table->timestamps();
        });

        Schema::create('delivery_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('delivery_id')->costrained('deliveries');
            $table->foreignId('product_id')->costrained('products');
            $table->integer('quantity')->nullable(false);
            $table->enum('origin', ['caritas', 'donation'])->default('caritas');
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
        Schema::drop('products');
        Schema::drop('delivery');
        Schema::drop('deliverydetails');
        Schema::drop('charities');
    }
};