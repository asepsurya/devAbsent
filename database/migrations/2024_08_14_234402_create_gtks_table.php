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
        Schema::create('gtks', function (Blueprint $table) {
            $table->id();
            $table->string('nik');
            $table->string('nama');
            $table->string('gender');
            $table->string('tempat_lahir');
            $table->string('tanggal_lahir');      
            $table->string('agama'); 
            $table->string('alamat');
            $table->string('telp');
            $table->string('id_provinsi');
            $table->string('id_kota');
            $table->string('id_kecamatan');
            $table->string('id_desa');
            $table->string('status')->nullable();
            $table->string('tanggal_masuk')->nullable();
            $table->string('id_rfid')->nullable();
            $table->string('id_jenis_gtk')->nullable();
            $table->string('gambar')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gtks');
    }
};
