<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableBaocaobaidang extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('baocaobaidang', function (Blueprint $table) {
            $table->increments('IDBaoCao');
            $table->unsignedInteger('IDNguoibaoCao');
            $table->foreign('IDNguoibaoCao')->references('IDKhachHang')->on('khachhang')->onDelete('cascade');
            $table->unsignedInteger('IDBaiDang');
            $table->foreign('IDBaiDang')->references('IDBaiDang')->on('baidang')->onDelete('cascade');
            $table->datetime('NgayBaoCao');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('baocaobaidang');
    }
}
