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
        Schema::table('vocabulary_words', function (Blueprint $table) {
            $table->string('part_of_speech')->nullable()->after('word');
            $table->string('pronunciation')->nullable()->after('part_of_speech');
            $table->text('example_sentence')->nullable()->after('example');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vocabulary_words', function (Blueprint $table) {
            $table->dropColumn(['part_of_speech', 'pronunciation', 'example_sentence']);
        });
    }
};
