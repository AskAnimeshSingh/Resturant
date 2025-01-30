<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrivacyPoliciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('privacy_policies', function (Blueprint $table) {
            $table->id();
            $table->string('heading1')->nullable();
            $table->string('answer1')->nullable();
            $table->string('heading2')->nullable();
            $table->longText('answer2')->nullable();
            $table->string('heading3')->nullable();
            $table->longText('answer3')->nullable();
            $table->string('heading4')->nullable();
            $table->longText('answer4')->nullable();
            $table->string('heading5')->nullable();
            $table->longText('answer5')->nullable();
            $table->string('heading6')->nullable();
            $table->longText('answer6')->nullable();
            $table->string('heading7')->nullable();
            $table->longText('answer7')->nullable();
            $table->string('heading8')->nullable();
            $table->longText('answer8')->nullable();
            $table->string('heading9')->nullable();
            $table->longText('answer9')->nullable();
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
        Schema::dropIfExists('privacy_policies');
    }
}
