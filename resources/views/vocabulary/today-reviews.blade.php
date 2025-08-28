@extends('layouts.app')

@section('content')
    <div class="bg-white rounded-lg shadow-md p-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">
            <i class="fas fa-calendar-day text-green-600 mr-2"></i>
            Ôn tập hôm nay
        </h1>

        @if ($todayReviews->count() > 0)
            <div class="space-y-4">
                @foreach ($todayReviews as $review)
                    <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                        <div class="flex justify-between items-start mb-3">
                            <div>
                                <h3 class="text-xl font-bold text-gray-800">
                                    {{ $review->vocabularyWord->word }}
                                    @if ($review->vocabularyWord->pronunciation)
                                        <span class="text-gray-500 text-sm ml-2">[{{ $review->vocabularyWord->pronunciation }}]</span>
                                    @endif
                                </h3>
                                <div class="flex items-center gap-2 text-sm text-gray-500">
                                    @if ($review->vocabularyWord->part_of_speech)
                                        <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs">
                                            {{ $review->vocabularyWord->getPartOfSpeechLabel() }}
                                        </span>
                                    @endif
                                    <span>Lần ôn thứ {{ $review->review_round }}</span>
                                </div>
                            </div>
                            <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded">
                                {{ $review->review_round }}/6
                            </span>
                        </div>

                        <div class="mb-4 space-y-2">
                            <p class="text-gray-700">
                                <strong>Nghĩa:</strong> {{ $review->vocabularyWord->meaning }}
                            </p>
                            @if ($review->vocabularyWord->example)
                                <p class="text-gray-600 text-sm italic">
                                    <strong>Ví dụ:</strong> "{{ $review->vocabularyWord->example }}"
                                </p>
                            @endif
                        </div>

                        <form action="{{ route('vocabulary.review', $review->vocabularyWord) }}" method="POST" class="flex justify-end">
                            @csrf
                            <button type="submit"
                                class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                                <i class="fas fa-check mr-2"></i>
                                Đã nhớ
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>

            <div class="mt-6 p-4 bg-green-50 rounded-lg">
                <p class="text-green-800 text-sm">
                    <i class="fas fa-lightbulb mr-2"></i>
                    <strong>Mẹo:</strong> Hãy cố gắng nhớ nghĩa của từ trước khi nhấn "Đã nhớ".
                    Việc này sẽ giúp bạn ghi nhớ từ vựng hiệu quả hơn!
                </p>
            </div>
        @else
            <div class="text-center py-12">
                <i class="fas fa-check-circle text-6xl text-green-500 mb-4"></i>
                <h3 class="text-xl font-semibold text-gray-700 mb-2">Tuyệt vời!</h3>
                <p class="text-gray-500 mb-4">Hôm nay không có từ nào cần ôn tập.</p>
                <a href="{{ route('vocabulary.index') }}" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700">
                    <i class="fas fa-plus mr-2"></i>
                    Thêm từ mới
                </a>
            </div>
        @endif
    </div>
@endsection
