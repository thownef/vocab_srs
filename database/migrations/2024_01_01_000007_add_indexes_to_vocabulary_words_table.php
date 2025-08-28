<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('vocabulary_words', function (Blueprint $table) {
            $table->index('word');
            $table->index('part_of_speech');
            $table->index('next_review_date');
        });
    }

    public function down(): void
    {
        Schema::table('vocabulary_words', function (Blueprint $table) {
            $table->dropIndex(['word']);
            $table->dropIndex(['part_of_speech']);
            $table->dropIndex(['next_review_date']);
        });
    }
};
