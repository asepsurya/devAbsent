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
        Schema::create('lisensis', function (Blueprint $table) {
            $table->id();
            $table->string('instansi_id')->unique(); // Perguruan Tinggi : NIDN,   Perguruan Menengah dan Dasar : NPSN
            $table->string('instansi'); // Nama Instansi
            $table->string('lisensi')->unique(); // Lisensi Code
            $table->enum('subscription_type', ['Lifetime', 'Yearly', 'Monthly']);
            $table->string('expired'); //  Tanggal Expired
            $table->enum('status', ['Active', 'Pending', 'Expired']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lisensis');
    }
};
