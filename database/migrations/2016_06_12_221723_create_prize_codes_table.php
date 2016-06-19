<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrizeCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prize_codes', function (Blueprint $table) {
            $table->increments('id');
            $table->smallInteger('type')->index();
            $table->string('prize_code',60);
            $table->boolean('is_active')->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('prize_codes');
    }
}
