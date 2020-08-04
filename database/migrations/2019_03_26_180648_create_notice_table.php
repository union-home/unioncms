<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNoticeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('module_notice', function (Blueprint $table) {
            $table->increments('nid')->comment('自增ID');
            $table->string('title')->comment('标题');
            $table->text('details')->comment('详情');
            $table->comment = '公告表';
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
        Schema::dropIfExists('module_notice');
    }
}
