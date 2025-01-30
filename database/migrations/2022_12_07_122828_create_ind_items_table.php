<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIndItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ind_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ind_grp_id');
            $table->foreign('ind_grp_id')->references('id')->on('ind_grps')->restrictOnDelete();
            $table->string('name');
            $table->tinyInteger('status')->default(1);
            $table->string('unit');
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
        Schema::dropIfExists('ind_items');
    }
}
