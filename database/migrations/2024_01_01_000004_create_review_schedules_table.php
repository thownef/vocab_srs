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
        Schema::create('review_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vocabulary_word_id')->constrained()->onDelete('cascade');
            $table->date('review_date');
            $table->integer('review_round');
            $table->boolean('is_completed')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('review_schedules');
    }
};
