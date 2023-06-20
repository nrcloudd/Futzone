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
        Schema::table('lapangans', function (Blueprint $table) {
            $table->unsignedBigInteger('tipeLapangan')->after('namaLapangan')->CascadeOnUpdate()->CascadeOnDelete();
            $table->foreign('tipeLapangan')->references('id')->on('tipe_lapangan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lapangans', function (Blueprint $table) {
            //
        });
    }
};
