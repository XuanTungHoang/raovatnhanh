<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableQuanhuyen extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quanhuyen', function (Blueprint $table) {
            $table->increments('IDQuanHuyen');
            $table->string('TenQuanHuyen')->unique();
            $table->integer('IDTinhThanh')->unsigned();
            $table->foreign('IDTinhThanh')->references('IDTinhThanh')->on('tinhthanh')->onDelete('cascade');
            $table->integer('TrangThai');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quanhuyen');
    }
}
