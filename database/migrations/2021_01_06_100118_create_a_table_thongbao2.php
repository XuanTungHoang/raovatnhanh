<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateATableThongbao2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('thongbao', function (Blueprint $table) {
            $table->increments('IDThongBao');
            $table->string('NoiDung');
            $table->integer('IDKhachHang')->unsigned();
            $table->foreign('IDKhachHang')->references('IDKhachHang')->on('khachhang');
            $table->time('NgayTao');
            $table->integer('TrangThai');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('thongbao');
    }
}
