<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableLinhkienmaytinh extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('linhkienmaytinh', function (Blueprint $table) {
            $table->increments('IDLinhKienMT');
            $table->unsignedInteger('IDTheLoaiSP')->nullable();
            $table->foreign('IDTheLoaiSP')->references('IDTheLoaiSP')->on('theloaisanpham')->onDelete('cascade');
            $table->string('TenLinhKienMT')->unique();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('linhkienmaytinh');
    }
}
