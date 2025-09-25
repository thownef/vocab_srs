<?php

namespace App\Http\Controllers;

use App\Enums\PartOfSpeech;
use App\Http\Requests\StoreVocabularyRequest;
use App\Http\Requests\UpdateVocabularyRequest;
use App\Models\ReviewSchedule;
use App\Models\VocabularyWord;
use App\Services\VocabularyService;

class VocabularyController extends Controller
{
    public function __construct(private VocabularyService $vocabularyService)
    {
        $this->vocabularyService = $vocabularyService;
    }

    public function index()
    {
        $partsOfSpeech = PartOfSpeech::options();

        $words = VocabularyWord::query()
            ->search(request('search'))
            ->partOfSpeech(request('part_of_speech'))
            ->orderByDesc('created_at')
            ->paginate(15)
            ->withQueryString();

        return view('vocabulary.index', compact('words', 'partsOfSpeech'));
    }

    public function create()
    {
        $partsOfSpeech = PartOfSpeech::options();
        return view('vocabulary.create', compact('partsOfSpeech'));
    }

    public function store(StoreVocabularyRequest $request)
    {
        $this->vocabularyService->create($request->validated());
        return redirect()->route('vocabulary.create')->with('success', 'Từ mới đã được thêm!');
    }

    public function edit(VocabularyWord $vocabulary)
    {
        $partsOfSpeech = PartOfSpeech::options();
        return view('vocabulary.edit', ['word' => $vocabulary, 'partsOfSpeech' => $partsOfSpeech]);
    }

    public function update(UpdateVocabularyRequest $request, VocabularyWord $vocabulary)
    {
        $vocabulary->update($request->validated());
        return redirect()->route('vocabulary.index')->with('success', 'Cập nhật thành công!');
    }

    public function destroy(VocabularyWord $vocabulary)
    {
        $vocabulary->delete();
        return redirect()->route('vocabulary.index')->with('success', 'Đã xóa từ vựng!');
    }

    public function review()
    {
        $todayReviews = ReviewSchedule::with('vocabularyWord')
            ->whereDate('review_date', '<=', today())
            ->where('is_completed', false)
            ->get();

        $groupedByDay = $todayReviews
            ->groupBy(fn($review) => $review->vocabularyWord->learning_day_number)
            ->sortKeys();

        return view('vocabulary.review', compact('groupedByDay'));
    }

    public function mark(VocabularyWord $vocabulary)
    {
        $this->vocabularyService->markReviewed($vocabulary);
        return redirect()->route('vocabulary.review')->with('success', 'Đã hoàn thành ôn tập!');
    }

    public function markForgotten(VocabularyWord $vocabulary)
    {
        $this->vocabularyService->markForgotten($vocabulary);
        return redirect()->route('vocabulary.review')->with('success', 'Đã đánh dấu quên từ, sẽ ôn lại từ đầu!');
    }

    public function markGroup()
    {
        $ids = collect(request('word_ids', []))
            ->filter(fn($v) => is_numeric($v))
            ->map(fn($v) => (int) $v)
            ->unique()
            ->values();

        if ($ids->isEmpty()) {
            return redirect()->route('vocabulary.review')->with('success', 'Không có từ nào để cập nhật.');
        }

        $words = VocabularyWord::whereIn('id', $ids)->get();
        foreach ($words as $word) {
            $this->vocabularyService->markReviewed($word);
        }

        return redirect()->route('vocabulary.review')->with('success', 'Đã hoàn thành ôn tập nhóm!');
    }
    public function summary()
    {
        $totalWords = VocabularyWord::count();

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
        $fivePlus = max(0, $totalWords - $sumZeroToFour);

        $reviewLabels = [
            'Chưa ôn (0)',
            '1 lần',
            '2 lần',
            '3 lần',
            '4 lần',
            '5+ lần',
        ];

        $reviewData = [
            $zero,
            $one,
            $two,
            $three,
            $four,
            $fivePlus,
        ];

        return view('vocabulary.summary', compact(
            'totalWords',
            'reviewLabels',
            'reviewData'
        ));
    }
}
