<?php

namespace App\Http\Controllers;

use App\Models\ReviewSchedule;
use App\Models\VocabularyWord;
use App\Services\VocabularyService;
use Livewire\Component;

class VocabularyReview extends Component
{
    public $groupedByDay = [];
    public $openSections = []; // Track which sections are open

    protected $vocabularyService;

    public function boot(VocabularyService $vocabularyService)
    {
        $this->vocabularyService = $vocabularyService;
    }

    public function mount()
    {
        $this->loadReviews();
    }

    public function loadReviews()
    {
        $todayReviews = ReviewSchedule::with('vocabularyWord')
            ->whereDate('review_date', '<=', today())
            ->where('is_completed', false)
            ->get();

        $this->groupedByDay = $todayReviews
            ->groupBy(fn($review) => $review->vocabularyWord->learning_day_number)
            ->sortKeys()
            ->toArray();
    }

    public function toggleSection($dayNumber)
    {
        if (in_array($dayNumber, $this->openSections)) {
            $this->openSections = array_diff($this->openSections, [$dayNumber]);
        } else {
            $this->openSections[] = $dayNumber;
        }
    }

    public function removeWordFromList($wordId, $dayNumber)
    {
        // Remove the word from the current list without reloading
        if (isset($this->groupedByDay[$dayNumber])) {
            $this->groupedByDay[$dayNumber] = array_filter(
                $this->groupedByDay[$dayNumber],
                fn($review) => $review['vocabulary_word_id'] != $wordId
            );

            // If no words left in this day, remove the day group
            if (empty($this->groupedByDay[$dayNumber])) {
                unset($this->groupedByDay[$dayNumber]);
                // Remove from open sections too
                $this->openSections = array_diff($this->openSections, [$dayNumber]);
            }
        }
    }

    public function markReviewed($wordId)
    {
        $word = VocabularyWord::find($wordId);
        if ($word) {
            $dayNumber = $word->learning_day_number;
            $this->vocabularyService->markReviewed($word);
            $this->removeWordFromList($wordId, $dayNumber);
            session()->flash('success', 'Đã hoàn thành ôn tập!');
        }
    }

    public function markForgotten($wordId)
    {
        $word = VocabularyWord::find($wordId);
        if ($word) {
            $dayNumber = $word->learning_day_number;
            $this->vocabularyService->markForgotten($word);
            $this->removeWordFromList($wordId, $dayNumber);
            session()->flash('success', 'Đã đánh dấu quên từ, sẽ ôn lại từ đầu!');
        }
    }

    public function markGroup($wordIds, $dayNumber)
    {
        $ids = collect($wordIds)
            ->filter(fn($v) => is_numeric($v))
            ->map(fn($v) => (int) $v)
            ->unique()
            ->values();

        if ($ids->isEmpty()) {
            session()->flash('success', 'Không có từ nào để cập nhật.');
            return;
        }

        $words = VocabularyWord::whereIn('id', $ids)->get();
        foreach ($words as $word) {
            $this->vocabularyService->markReviewed($word);
        }

        // Remove all words in this day group
        unset($this->groupedByDay[$dayNumber]);
        $this->openSections = array_diff($this->openSections, [$dayNumber]);

        session()->flash('success', 'Đã hoàn thành ôn tập nhóm!');
    }

    public function render()
    {
        return view('vocabulary-review');
    }
}
