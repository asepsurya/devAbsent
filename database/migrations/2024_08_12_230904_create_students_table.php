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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('nis');
            $table->string('nama');
            $table->string('gender');
            $table->string('tempat_lahir');
            $table->string('tanggal_lahir');
            $table->string('agama');
            $table->string('alamat')->nullable();
            $table->string('id_provinsi')->nullable();
            $table->string('id_kota')->nullable();
            $table->string('id_kecamatan')->nullable();
            $table->string('id_desa')->nullable();
            $table->string('status')->nullable();
            $table->string('tanggal_masuk')->nullable();
            $table->string('id_rfid')->nullable();
            $table->string('id_user')->nullale();
            $table->string('id_kelas')->nullable();
            $table->string('id_rombel')->nullable();
            $table->string('id_tahun_ajar')->nullable();
            $table->string('foto')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
