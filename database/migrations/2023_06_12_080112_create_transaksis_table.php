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
            $table->unsignedBigInteger('id_lapangan')->after('id')->foreignId('id_lapangan')->nullable()->after('id')->Constrained()->CascadeOnUpdate()->CascadeOnDelete();
            $table->foreign('id_lapangan')->references('id')->on('lapangans');
            $table->unsignedBigInteger('id_user')->after('id_lapangan')->foreignId('id_user')->nullable()->after('id_lapangan')->Constrained()->CascadeOnUpdate()->CascadeOnDelete();
            $table->foreign('id_user')->references('id')->on('users');
            $table->time('jam');
            $table->date('tanggal');
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
