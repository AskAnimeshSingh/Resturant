<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFoodPurchaseHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('food_purchase_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('food_purchase_id');
            $table->foreign('food_purchase_id')->references('id')->on('food_purchases')->restrictOnDelete();
            $table->double('qty');
            $table->double('price');
            $table->double('total_price');
            $table->unsignedBigInteger('branch_id');
            $table->foreign('branch_id')->references('id')->on('branches')->restrictOnDelete();
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
        Schema::dropIfExists('food_purchase_histories');
    }
}
