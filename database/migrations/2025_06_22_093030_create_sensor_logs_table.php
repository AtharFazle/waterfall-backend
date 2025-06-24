<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sensor_logs', function (Blueprint $table) {
            $table->id();
            $table->timestamp('logged_at')->index(); // waktu saat data masuk
            $table->float('suhu')->nullable();
            $table->float('kelembapan')->nullable();
            $table->float('kecepatan_angin')->nullable();
            $table->float('debit_air')->nullable();
            $table->float('ketinggian_air')->nullable();
            // $table->integer('total_pengunjung')->nullable();
            // $table->integer('pengunjung_now')->nullable();
            $table->string('source')->default('iot'); // bisa iot/manual/frontend
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sensor_logs');
    }
};
