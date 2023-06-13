<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_member');
            $table->unsignedBigInteger('id_lapangan');
            $table->foreign('id_member')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_lapangan')->references('id')->on('lapangans')->onDelete('cascade');
            $table->time('jam');
            $table->date('tanggal');
            $table->integer('total_bayar');
            $table->string('bukti_bayar');
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
        Schema::dropIfExists('transaksis');
    }
};
