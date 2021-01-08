<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableForeignTheloaisp3 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dienthoai', function (Blueprint $table) {
            $table->unsignedInteger('IDTheLoaiSP')->after('IDHangSX')->nullable();
            $table->foreign('IDTheLoaiSP')->references('IDTheLoaiSP')->on('theloaisanpham')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dienthoai', function (Blueprint $table) {
            $table->dropColumn('IDTheLoaiSP');
        });
    }
}
