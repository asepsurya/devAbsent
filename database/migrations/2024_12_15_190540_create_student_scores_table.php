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
        Schema::create('student_scores', function (Blueprint $table) {
                $table->id();
                $table->string('task_id');
                $table->string('student_id');
                $table->integer('benar')->default(0);
                $table->integer('nilai')->default(0);
                $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_scores');
    }
};
