<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLotteryConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lottery_configs', function (Blueprint $table) {
            $table->increments('id');
            $table->time('start_time')->index();
            $table->time('shut_time')->index();
            $table->decimal('win_odds',5,4);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('lottery_configs');
    }
}
