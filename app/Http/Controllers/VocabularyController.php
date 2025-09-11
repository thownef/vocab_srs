<?php

namespace App\Http\Controllers;

use App\Enums\PartOfSpeech;
use App\Http\Requests\StoreVocabularyRequest;
use App\Http\Requests\UpdateVocabularyRequest;
use App\Models\ReviewSchedule;
use App\Models\VocabularyWord;
use App\Services\VocabularyService;
use Carbon\Carbon;

class VocabularyController extends Controller
{
    public function __construct(private VocabularyService $service) {}

    public function index()
    {
        $partsOfSpeech = PartOfSpeech::options();
        return view('vocabulary.index', compact('partsOfSpeech'));
    }

    public function store(StoreVocabularyRequest $request)
    {
        $this->service->create($request->validated());
        return redirect()->route('vocabulary.index')->with('success', 'Từ mới đã được thêm!');
    }

    public function edit(VocabularyWord $vocabulary)
    {
        $partsOfSpeech = PartOfSpeech::options();
        return view('vocabulary.edit', ['word' => $vocabulary, 'partsOfSpeech' => $partsOfSpeech]);
    }

    public function update(UpdateVocabularyRequest $request, VocabularyWord $vocabulary)
    {
        $vocabulary->update($request->validated());
        return redirect()->route('vocabulary.all-words')->with('success', 'Cập nhật thành công!');
    }

    public function destroy(VocabularyWord $vocabulary)
    {
        $vocabulary->delete();
        return redirect()->route('vocabulary.all-words')->with('success', 'Đã xóa từ vựng!');
    }

    public function todayReviews()
    {
        $todayReviews = ReviewSchedule::with('vocabularyWord')
            ->whereDate('review_date', today())
            ->where('is_completed', false)
            ->get();

        $groupedByDay = $todayReviews
            ->groupBy(fn($review) => $review->vocabularyWord->learning_day_number)
            ->sortKeys();

        return view('vocabulary.today-reviews', compact('groupedByDay'));
    }

    public function markAsReviewed(VocabularyWord $vocabulary)
    {
        $this->service->markReviewed($vocabulary);
        return redirect()->route('vocabulary.today-reviews')->with('success', 'Đã hoàn thành ôn tập!');
    }

    public function markGroupReviewed()
    {
        $ids = collect(request('word_ids', []))
            ->filter(fn($v) => is_numeric($v))
            ->map(fn($v) => (int) $v)
            ->unique()
            ->values();

        if ($ids->isEmpty()) {
            return redirect()->route('vocabulary.today-reviews')->with('success', 'Không có từ nào để cập nhật.');
        }

        $words = VocabularyWord::whereIn('id', $ids)->get();
        foreach ($words as $word) {
            $this->service->markReviewed($word);
        }

        return redirect()->route('vocabulary.today-reviews')->with('success', 'Đã hoàn thành ôn tập nhóm!');
    }

    public function allWords()
    {
        $partsOfSpeech = PartOfSpeech::options();

        $words = VocabularyWord::query()
            ->search(request('search'))
            ->partOfSpeech(request('part_of_speech'))
            ->orderByDesc('created_at')
            ->paginate(15)
            ->withQueryString();

        return view('vocabulary.all-words', compact('words', 'partsOfSpeech'));
    }
}
