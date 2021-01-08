<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateATableThongindienthoai2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('thongtindienthoai', function (Blueprint $table) {
            $table->increments('IDModelDT');
            $table->integer('IDHangSX')->unsigned();
            $table->foreign('IDHangSX')->references('IDHangSX')->on('dienthoai')->onDelete('cascade');
            $table->string('TenModelDT');
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
        Schema::dropIfExists('thongtindienthoai');
    }
}
