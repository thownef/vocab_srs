<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('vocabulary_words', function (Blueprint $table) {
            $table->integer('learning_day_number')->nullable()->after('created_date');
            $table->index('learning_day_number');
        });

        $dates = DB::table('vocabulary_words')
            ->select('created_date')
            ->distinct()
            ->orderBy('created_date')
            ->pluck('created_date');

        $i = 1;
        foreach ($dates as $d) {
            DB::table('vocabulary_words')
                ->whereDate('created_date', $d)
                ->update(['learning_day_number' => $i]);
            $i++;
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vocabulary_words', function (Blueprint $table) {
            $table->dropIndex(['learning_day_number']);
            $table->dropColumn('learning_day_number');
        });
    }
};
