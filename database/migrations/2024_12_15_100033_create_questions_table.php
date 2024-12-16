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
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->string('task_id');
            $table->text('soal');
            $table->text('pilihan_a');
            $table->text('pilihan_b');
            $table->text('pilihan_c');
            $table->text('pilihan_d');
            $table->text('pilihan_e');
            $table->enum('jawaban', ['A', 'B', 'C', 'D', 'E']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
