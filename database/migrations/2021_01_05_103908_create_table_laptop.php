<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableLaptop extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('laptop', function (Blueprint $table) {
            $table->increments('IDHangSX');
            $table->unsignedInteger('IDTheLoaiSP')->nullable();
            $table->foreign('IDTheLoaiSP')->references('IDTheLoaiSP')->on('theloaisanpham')->onDelete('cascade');
            $table->string('TenHangSX');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('laptop');
    }
}
