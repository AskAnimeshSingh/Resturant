<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGeneralsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('generals', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('address');
            $table->mediumInteger('phone');
            $table->integer('back_logo_col');
            $table->integer('back_foot_col');
            $table->integer('currency_col');
            $table->string('logo');
            $table->string('favicon');
            $table->double('tax' , 8,2)->default(0);
            $table->double('discount' , 8,2)->default(0);
            $table->time('timezone');
            $table->string('bill_head');
            $table->string('bill_foot');
            $table->string('order_detail');
            $table->string('beep_sound');
            $table->string('show_table');
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
        Schema::dropIfExists('generals');
    }
}
