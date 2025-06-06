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
        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->string('day'); // mengambil data mata pelajaran
            $table->string('id_mapel'); // mengambil data mata pelajaran
            $table->string('id_gtk')->nullable(); // mengambil data guru mata pelajaran
            $table->string('id_rombel'); // mengambil data rombel
            $table->string('id_tahun_ajar'); // mengambil data tahun ajar
            $table->string('sk')->nullable(); // input nomor sk
            $table->string('tanggal_sk')->nullable(); // input tanggal sk
            $table->string('status');
            $table->string('start');
            $table->string('end');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lessons');
    }
};
