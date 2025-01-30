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
            $table->string('product_name');
            $table->string('product_img');
            $table->text('product_des')->nullable();
            $table->integer('qty')->default(0);
            $table->double('price_large' , 8,2);
            $table->double('price_medium' , 8,2);
            $table->double('price_small' , 8,2);
            $table->double('tax' , 8,2)->default(0);
            $table->tinyInteger('status')->default(1);
            $table->unsignedBigInteger('category');
            $table->foreign('category')->references('id')->on('categories')->restrictOnDelete();
            $table->unsignedBigInteger('sub_category');
            $table->foreign('sub_category')->references('id')->on('sub_categories')->restrictOnDelete();
            $table->unsignedBigInteger('child_category');
            $table->foreign('child_category')->references('id')->on('child_categories')->restrictOnDelete();
            $table->string('size');
            $table->string('type')->nullable();
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
