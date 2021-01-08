<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableThongtinlaptop extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('thongtinlaptop', function (Blueprint $table) {
            $table->increments('IDModelLT');
            $table->integer('IDHangSX')->unsigned();
            $table->foreign('IDHangSX')->references('IDHangSX')->on('laptop')->onDelete('cascade');
            $table->string('TenModelLT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('thongtinlaptop');
    }
}
