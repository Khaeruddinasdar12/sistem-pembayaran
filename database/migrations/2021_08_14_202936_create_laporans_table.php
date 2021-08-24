<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLaporansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('laporans', function (Blueprint $table) {
            $table->id();
            $table->integer('meter_bulan_lalu');
            $table->integer('meter_bulan_ini');
            $table->integer('pemakaian');
            $table->integer('total');
            $table->enum('status', ['0', '1']); // 0 = belum lunas, 1 = lunas
            $table->datetime('lunas_at')->nullable();
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('updated_by')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('admins');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('laporans');
    }
}
