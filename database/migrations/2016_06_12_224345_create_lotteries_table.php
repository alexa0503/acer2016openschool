<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLotteriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lotteries', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('wechat_users');
            $table->string('snid',60)->index()->nullable();
            $table->boolean('has_lottery')->index();
            $table->smallInteger('prize')->index();
            $table->smallInteger('prize_type')->index();
            $table->integer('prize_code_id')->unsigned()->nullable();
            $table->foreign('prize_code_id')->references('id')->on('prize_codes');
            $table->dateTime('lottery_time')->index()->nullable();
            $table->dateTime('created_time')->index();
            $table->string('created_ip',120)->nullable();
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('lotteries');
    }
}
