<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTermsAndConditionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('terms_and_conditions', function (Blueprint $table) {
            $table->id();
            $table->string('heading1')->nullable();
            $table->longText('answer1')->nullable();
            $table->string('heading2')->nullable();
            $table->longText('answer2')->nullable();
            $table->string('heading3')->nullable();
            $table->longText('answer3')->nullable();
            $table->string('heading4')->nullable();
            $table->longText('answer4')->nullable();
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
        Schema::dropIfExists('terms_and_conditions');
    }
}
