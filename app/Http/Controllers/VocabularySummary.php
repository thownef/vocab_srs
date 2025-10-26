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

        // MongoDB aggregation to count by review_count
        $countsByReview = VocabularyWord::raw(function ($collection) {
            return $collection->aggregate([
                [
                    '$group' => [
                        '_id' => '$review_count',
                        'cnt' => ['$sum' => 1]
                    ]
                ],
                [
                    '$project' => [
                        'review_count' => '$_id',
                        'cnt' => 1,
                        '_id' => 0
                    ]
                ]
            ]);
        });

        // Convert to array format
        $countsByReviewArray = [];
        foreach ($countsByReview as $item) {
            $countsByReviewArray[$item['review_count']] = $item['cnt'];
        }

        $zero = (int) ($countsByReviewArray[0] ?? 0);
        $one = (int) ($countsByReviewArray[1] ?? 0);
        $two = (int) ($countsByReviewArray[2] ?? 0);
        $three = (int) ($countsByReviewArray[3] ?? 0);
        $four = (int) ($countsByReviewArray[4] ?? 0);

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
        return view('vocabulary.summary');
    }
}
