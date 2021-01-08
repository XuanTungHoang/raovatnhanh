<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableTindaluu1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tindaluu', function (Blueprint $table) {
            $table->increments('IDTinLuu');
            $table->unsignedInteger('IDBaiDang');
            $table->foreign('IDBaiDang')->references('IDBaiDang')->on('baidang')->onDelete('cascade');
            $table->unsignedInteger('IDKhachHang');
            $table->foreign('IDKhachHang')->references('IDKhachHang')->on('khachhang')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tindaluu');
    }
}
