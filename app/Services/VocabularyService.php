<?php

namespace App\Services;

use App\Models\ReviewSchedule;
use App\Models\VocabularyWord;
use Illuminate\Support\Facades\DB;

class VocabularyService
{
    private array $intervals = [0, 1, 2, 4, 8, 15, 30];

    public function create(array $data): VocabularyWord
    {
        return DB::transaction(function () use ($data) {
            $today = today();

            $word = VocabularyWord::create([
                'word' => $data['word'],
                'part_of_speech' => $data['part_of_speech'] ?? null,
                'pronunciation' => $data['pronunciation'] ?? null,
                'meaning' => $data['meaning'],
                'review_count' => 0,
                'next_review_date' => $today,
                'created_date' => $today,
            ]);

            ReviewSchedule::firstOrCreate([
                'vocabulary_word_id' => $word->id,
                'review_date' => $today,
            ], [
                'review_round' => 1,
            ]);

            return $word;
        });
    }

    public function markReviewed(VocabularyWord $word): void
    {
        DB::transaction(function () use ($word) {
            $today = today();

            $word->increment('review_count');

            $index = min($word->review_count, count($this->intervals) - 1);
            $next = $today->copy()->addDays($this->intervals[$index]);

            $word->update(['next_review_date' => $next]);

            // Mark today's schedules complete (idempotent)
            $word->reviewSchedules()
                ->whereDate('review_date', $today)
                ->update(['is_completed' => true]);

            // Avoid duplicate schedule for the same next date
            ReviewSchedule::firstOrCreate([
                'vocabulary_word_id' => $word->id,
                'review_date' => $next,
            ], [
                // round 1 was created on create(); after first review, this becomes 2, etc.
                'review_round' => $word->review_count + 1,
            ]);
        });
    }
}
