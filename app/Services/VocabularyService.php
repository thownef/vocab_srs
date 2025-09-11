<?php

namespace App\Services;

use App\Models\VocabularyWord;
use Illuminate\Support\Facades\DB;

class VocabularyService
{
    private array $intervals = [0, 1, 2, 4, 8, 15, 30];

    public function create(array $data): VocabularyWord
    {
        return DB::transaction(function () use ($data) {
            $today = today();

            $existing = VocabularyWord::whereDate('created_date', $today)->value('learning_day_number');
            $dayNumber = $existing ?? ((int) VocabularyWord::max('learning_day_number') + 1);

            $word = VocabularyWord::create([
                'word' => $data['word'],
                'part_of_speech' => $data['part_of_speech'] ?? null,
                'pronunciation' => $data['pronunciation'] ?? null,
                'meaning' => $data['meaning'],
                'review_count' => 0,
                'next_review_date' => $today,
                'created_date' => $today,
                'learning_day_number' => $dayNumber,
            ]);

            $word->reviewSchedules()->firstOrCreate(
                ['review_date' => $today],
                ['review_round' => 1]
            );

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

            $word->reviewSchedules()
                ->whereDate('review_date', $today)
                ->update(['is_completed' => true]);

            $word->reviewSchedules()->firstOrCreate(
                ['review_date' => $next],
                ['review_round' => $word->review_count + 1]
            );
        });
    }
}
