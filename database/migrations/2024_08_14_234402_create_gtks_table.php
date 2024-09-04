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
            $table->string('nip')->nullable()->unique();
            $table->string('nama');
            $table->string('gender');
            $table->string('tempat_lahir');
            $table->string('tanggal_lahir');
            $table->string('agama');
            $table->string('alamat')->nullable();
            $table->string('telp');
            $table->string('id_provinsi')->nullable();
            $table->string('id_kota')->nullable();
            $table->string('id_kecamatan')->nullable();
            $table->string('id_desa')->nullable();
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
