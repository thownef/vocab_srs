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
        // Use array_flip for O(1) lookup performance instead of in_array O(n)
        $openSectionsFlipped = array_flip($this->openSections);

        if (isset($openSectionsFlipped[$dayNumber])) {
            // Remove from open sections
            $this->openSections = array_values(array_diff($this->openSections, [$dayNumber]));
        } else {
            // Add to open sections
            $this->openSections[] = $dayNumber;
        }
    }

    public function isSectionOpen($dayNumber)
    {
        return in_array($dayNumber, $this->openSections);
    }

    public function openAllSections()
    {
        $this->openSections = array_keys($this->groupedByDay);
    }

    public function closeAllSections()
    {
        $this->openSections = [];
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
            ->unique()
            ->values();

        if ($ids->isEmpty()) {
            session()->flash('success', 'Không có từ nào để cập nhật.');
            return;
        }

        $words = VocabularyWord::whereIn('_id', $ids)->get();
        foreach ($words as $word) {
            $this->vocabularyService->markReviewed($word);
        }

        // Remove all words in this day group
        unset($this->groupedByDay[$dayNumber]);
        $this->openSections = array_diff($this->openSections, [$dayNumber]);

        session()->flash('success', 'Đã hoàn thành ôn tập nhóm!');
    }

    public function markGroupForgotten($wordIds, $dayNumber)
    {
        $ids = collect($wordIds)
            ->unique()
            ->values();

        if ($ids->isEmpty()) {
            session()->flash('success', 'Không có từ nào để cập nhật.');
            return;
        }

        $words = VocabularyWord::whereIn('_id', $ids)->get();
        foreach ($words as $word) {
            $this->vocabularyService->markForgotten($word);
        }

        // Remove all words in this day group
        unset($this->groupedByDay[$dayNumber]);
        $this->openSections = array_diff($this->openSections, [$dayNumber]);

        session()->flash('success', 'Đã đánh dấu quên tất cả từ trong nhóm, sẽ ôn lại từ đầu!');
    }

    public function render()
    {
        return view('vocabulary.review');
    }
}
