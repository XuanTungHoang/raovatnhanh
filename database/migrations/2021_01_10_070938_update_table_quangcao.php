<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTableQuangcao extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('quangcao', function (Blueprint $table) {
            $table->unsignedInteger('IDTheLoaiSP')->after('IDQuangCao');
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
        Schema::table('quangcao', function (Blueprint $table) {
            $table->dropColumn('IDTheLoaiSP');
        });
    }
}
