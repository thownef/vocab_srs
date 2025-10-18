<?php

namespace App\Http\Controllers;

use App\Models\VocabularyWord;
use Livewire\Component;

class VocabularySummary extends Component
{
    public $totalWords;
    public $reviewLabels;
    public $reviewData;

    public function mount()
    {
        $this->loadSummaryData();
    }

    public function loadSummaryData()
    {
        $this->totalWords = VocabularyWord::count();

        $countsByReview = VocabularyWord::query()
            ->selectRaw('review_count, COUNT(*) as cnt')
            ->groupBy('review_count')
            ->pluck('cnt', 'review_count');

        $zero = (int) ($countsByReview[0] ?? 0);
        $one = (int) ($countsByReview[1] ?? 0);
        $two = (int) ($countsByReview[2] ?? 0);
        $three = (int) ($countsByReview[3] ?? 0);
        $four = (int) ($countsByReview[4] ?? 0);

        $sumZeroToFour = $zero + $one + $two + $three + $four;
        $fivePlus = max(0, $this->totalWords - $sumZeroToFour);

        $this->reviewLabels = [
            'Chưa ôn (0)',
            '1 lần',
            '2 lần',
            '3 lần',
            '4 lần',
            '5+ lần',
        ];

        $this->reviewData = [
            $zero,
            $one,
            $two,
            $three,
            $four,
            $fivePlus,
        ];
    }

    public function render()
    {
        return view('vocabulary-summary');
    }
}
