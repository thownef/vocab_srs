<?php

namespace App\Http\Controllers;

use App\Models\ReviewSchedule;
use App\Models\VocabularyWord;
use App\Services\VocabularyService;
use Livewire\Component;

class VocabularyReview extends Component
{
    public $groupedByDay = [];

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

    public function markReviewed($wordId)
    {
        $word = VocabularyWord::find($wordId);
        if ($word) {
            $this->vocabularyService->markReviewed($word);
            session()->flash('success', 'Đã hoàn thành ôn tập!');
            $this->loadReviews();
        }
    }

    public function markForgotten($wordId)
    {
        $word = VocabularyWord::find($wordId);
        if ($word) {
            $this->vocabularyService->markForgotten($word);
            session()->flash('success', 'Đã đánh dấu quên từ, sẽ ôn lại từ đầu!');
            $this->loadReviews();
        }
    }

    public function markGroup($wordIds)
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

        session()->flash('success', 'Đã hoàn thành ôn tập nhóm!');
        $this->loadReviews();
    }

    public function render()
    {
        return view('vocabulary-review');
    }
}
