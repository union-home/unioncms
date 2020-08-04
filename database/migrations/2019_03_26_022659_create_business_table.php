<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBusinessTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('module_business', function (Blueprint $table) {
            $table->increments('id')->comment('自增ID');
            $table->string('business_name')->comment('商家名');
            $table->string('intro')->comment('简介');
            $table->string(' address')->comment('地址');
            $table->comment = '商家表';
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
        //
        Schema::dropIfExists('module_business');
    }
}
