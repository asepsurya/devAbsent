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
        Schema::create('absent_mapels', function (Blueprint $table) {
            $table->id();
            $table->string('tanggal');
            $table->string('nis');
            $table->string('id_mapel');
            $table->string('id_gtk');
            $table->string('id_kelas');
            $table->string('entry')->nullable();
            $table->string('status')->nullable();
            $table->string('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absent_mapels');
    }
};
