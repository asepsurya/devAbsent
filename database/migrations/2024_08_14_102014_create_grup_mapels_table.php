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
        Schema::create('grup_mapels', function (Blueprint $table) {
            $table->id();
            $table->string('id_tahun_pelajaran')->nullable();
            $table->string('id_kelas')->nullable();
            $table->string('id_mapel')->nullable();
            $table->string('status')->nullable();
        
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grup_mapels');
    }
};
