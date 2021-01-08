<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableBaidang extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('baidang', function (Blueprint $table) {
            $table->increments('IDBaiDang');
            $table->unsignedInteger('IDKhachHang');
            $table->foreign('IDKhachHang')->references('IDKhachHang')->on('khachhang')->onDelete('cascade');
            $table->string('TieuDe');
            $table->string('NoiDung');
            $table->string('HinhAnh');
            $table->unsignedInteger('IDTheLoaiSP');
            $table->foreign('IDTheLoaiSP')->references('IDTheLoaiSP')->on('theloaisanpham')->onDelete('cascade');
            $table->integer('IDModel');
            $table->double('GiaBan');
            $table->string('TinhThanh');
            $table->string('QuanHuyen');
            $table->date('NgayDang');
            $table->string('TrangThai');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('baidang');
    }
}
