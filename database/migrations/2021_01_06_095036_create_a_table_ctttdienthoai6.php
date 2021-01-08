<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateATableCtttdienthoai6 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ctdienthoai', function (Blueprint $table) {
            $table->unsignedInteger('IDModelDT')->unique();
            $table->foreign('IDModelDT')->references('IDModelDT')->on('thongtindienthoai')->onDelete('cascade');
            $table->string('HeDieuHanh');
            $table->string('KichThuoc');
            $table->string('ChipXuLi');
            $table->string('Ram');
            $table->string('Camera');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ctdienthoai');
    }
}
