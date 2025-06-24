<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('sensors', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->float('kelembapan');
            $table->float('kecepatan_angin');
            $table->float('debit_air');
            $table->float('ketinggian_air');
            $table->integer('total_pengunjung')->nullable();
            $table->integer('pengunjung_now')->nullable();
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sensors');
    }
};
