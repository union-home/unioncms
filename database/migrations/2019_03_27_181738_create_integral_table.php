<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIntegralTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('module_commission_integral', function (Blueprint $table) {
            $table->increments('id')->comment('自增ID');
            $table->string('commodity')->comment('商品');
            $table->dateTime('time')->comment('时间');
            $table->unsignedInteger('integral')->comment('收入积分');
            $table->timestamps();
            $table->comment='积分记录表';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('module_commission_integral');
    }
}
