<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSignInTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('module_commission_sign_in', function (Blueprint $table) {
            $table->increments('id')->comment('自增ID');
            $table->dateTime('sign_in_date')->comment('签到日期');
            $table->timestamps();
            $table->comment='签到表';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('module_commission_sign_in');
    }
}
