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
        Schema::create('mapels', function (Blueprint $table) {
            $table->id();
            $table->String('nama');
            $table->String('kode_mapel')->nullable(); // input kode mapel
            $table->String('jml_jam'); // dijadikan patokan max jam pelajaran
            $table->enum('type', ['umum', 'kejuruan', 'pilihan']); // kelompok mapel
            $table->String('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mapels');
    }
};
