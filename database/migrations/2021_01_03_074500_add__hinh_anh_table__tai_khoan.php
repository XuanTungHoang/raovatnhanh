<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddHinhAnhTableTaiKhoan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('taikhoan', function (Blueprint $table) {
            $table->string('HinhAnh')->after('TenTaiKhoan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('taikhoan', function (Blueprint $table) {
            $table->dropColumn('HinhAnh');
        });
    }
}
