<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('supplier_id');
            $table->unsignedBigInteger('brand_id');
            $table->string('slug')->unique();
            $table->string('name');
            $table->string('image');
            $table->integer('discount_price');
            $table->integer('buy_price');
            $table->integer('sale_price');
            $table->integer('total_quantity');
            $table->integer('view_count')->default(0);
            $table->integer('like_count')->default(0);
            $table->longText('description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
