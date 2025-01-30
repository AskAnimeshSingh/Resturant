<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('table_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('book_table_id');
            $table->date('start_date');
            $table->date('end_date');
            $table->time('stat_time');
            $table->time('end_time');
            $table->string('area');
            $table->integer('table_num');
            $table->string('first_name');
            $table->string('last_name');

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
        Schema::dropIfExists('table_details');
    }
}
