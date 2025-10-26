<div class="bg-white rounded-lg shadow-md p-6">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">
        <i class="fas fa-calendar-day text-green-600 mr-2"></i>
        Ôn tập hôm nay
    </h1>

    @if (!empty($groupedByDay))
        <div class="space-y-4">
            @foreach ($groupedByDay as $dayNumber => $reviews)
                <div class="border border-gray-200 rounded-lg transition-all duration-200 hover:shadow-md">
                    <div class="cursor-pointer select-none px-4 py-3 flex items-center justify-between" wire:click="toggleSection({{ $dayNumber }})"
                        role="button" tabindex="0" aria-expanded="{{ $this->isSectionOpen($dayNumber) ? 'true' : 'false' }}"
                        aria-controls="section-content-{{ $dayNumber }}" @keydown.enter="$wire.toggleSection({{ $dayNumber }})"
                        @keydown.space.prevent="$wire.toggleSection({{ $dayNumber }})">
                        <div class="text-lg font-semibold text-gray-800">
                            <i
                                class="fas {{ $this->isSectionOpen($dayNumber) ? 'fa-chevron-down' : 'fa-chevron-right' }} mr-2 text-sm transition-transform duration-200"></i>
                            Ôn tập ngày {{ $dayNumber }}
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                {{ count($reviews) }} từ
                            </span>
                            <div class="flex gap-2">
                                <button
                                    wire:click.stop="markGroupForgotten({{ json_encode(collect($reviews)->pluck('vocabulary_word_id')->toArray()) }}, {{ $dayNumber }})"
                                    wire:confirm="Bạn có chắc chắn đã quên tất cả {{ count($reviews) }} từ trong ngày {{ $dayNumber }}? Tất cả từ sẽ được ôn lại từ đầu."
                                    class="bg-red-600 text-white px-3 py-1.5 rounded text-xs hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 disabled:opacity-50"
                                    wire:loading.attr="disabled">
                                    <span wire:loading.remove
                                        wire:target="markGroupForgotten({{ json_encode(collect($reviews)->pluck('vocabulary_word_id')->toArray()) }}, {{ $dayNumber }})">
                                        <i class="fas fa-times mr-1"></i>
                                        Quên tất cả
                                    </span>
                                    <span wire:loading
                                        wire:target="markGroupForgotten({{ json_encode(collect($reviews)->pluck('vocabulary_word_id')->toArray()) }}, {{ $dayNumber }})">
                                        <i class="fas fa-spinner fa-spin mr-1"></i>
                                        Đang xử lý...
                                    </span>
                                </button>
                                <button
                                    wire:click.stop="markGroup({{ json_encode(collect($reviews)->pluck('vocabulary_word_id')->toArray()) }}, {{ $dayNumber }})"
                                    wire:confirm="Bạn có chắc chắn đã nhớ tất cả {{ count($reviews) }} từ trong ngày {{ $dayNumber }}?"
                                    class="bg-green-600 text-white px-3 py-1.5 rounded text-xs hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 disabled:opacity-50"
                                    wire:loading.attr="disabled">
                                    <span wire:loading.remove
                                        wire:target="markGroup({{ json_encode(collect($reviews)->pluck('vocabulary_word_id')->toArray()) }}, {{ $dayNumber }})">
                                        <i class="fas fa-check mr-1"></i>
                                        Đã nhớ tất cả
                                    </span>
                                    <span wire:loading
                                        wire:target="markGroup({{ json_encode(collect($reviews)->pluck('vocabulary_word_id')->toArray()) }}, {{ $dayNumber }})">
                                        <i class="fas fa-spinner fa-spin mr-1"></i>
                                        Đang xử lý...
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>

                    @if ($this->isSectionOpen($dayNumber))
                        <div class="p-4 space-y-4 border-t border-gray-200 animate-fadeIn" id="section-content-{{ $dayNumber }}" role="region"
                            aria-labelledby="section-header-{{ $dayNumber }}">
                            @foreach ($reviews as $review)
                                <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow"
                                    wire:key="word-'{{ $review['vocabulary_word_id'] }}'">
                                    <div class="flex justify-between items-start mb-3">
                                        <div>
                                            <h3 class="text-xl font-bold text-gray-800">
                                                {{ $review['vocabulary_word']['word'] }}
                                                @if (!empty($review['vocabulary_word']['pronunciation']))
                                                    <span class="text-gray-500 text-sm ml-2">[{{ $review['vocabulary_word']['pronunciation'] }}]</span>
                                                @endif
                                            </h3>
                                            <div class="flex items-center gap-2 text-sm text-gray-500">
                                                @if (!empty($review['vocabulary_word']['part_of_speech']))
                                                    <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs">
                                                        {{ $review['vocabulary_word']['part_of_speech'] }}
                                                    </span>
                                                @endif
                                                <span>Lần ôn thứ {{ $review['review_round'] }}</span>
                                            </div>
                                        </div>
                                        <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded">
                                            {{ $review['review_round'] }}/6
                                        </span>
                                    </div>

                                    <!-- Meaning section with toggle -->
                                    <div class="mt-3">
                                        <button onclick="document.getElementById('meaning-{{ $review['vocabulary_word_id'] }}').classList.toggle('hidden')"
                                            class="text-blue-600 hover:text-blue-800 text-sm font-medium focus:outline-none">
                                            <i class="fas fa-eye mr-1"></i>
                                            Xem nghĩa
                                        </button>
                                        <div id="meaning-{{ $review['vocabulary_word_id'] }}" class="hidden mt-2 p-3 bg-gray-50 rounded-lg border">
                                            <div class="text-gray-700">
                                                <strong>Nghĩa:</strong> {{ $review['vocabulary_word']['meaning'] }}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="flex justify-end gap-2 mt-4">
                                        <button wire:click="markForgotten('{{ $review['vocabulary_word_id'] }}')"
                                            wire:confirm="Bạn có chắc chắn đã quên từ này? Từ sẽ được ôn lại từ đầu."
                                            class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 disabled:opacity-50"
                                            wire:loading.attr="disabled">
                                            <span wire:loading.remove wire:target="markForgotten">
                                                <i class="fas fa-times mr-2"></i>
                                                Quên
                                            </span>
                                            <span wire:loading wire:target="markForgotten">
                                                <i class="fas fa-spinner fa-spin mr-2"></i>
                                                Đang xử lý...
                                            </span>
                                        </button>
                                        <button wire:click="markReviewed('{{ $review['vocabulary_word_id'] }}')"
                                            class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 disabled:opacity-50"
                                            wire:loading.attr="disabled">
                                            <span wire:loading.remove wire:target="markReviewed">
                                                <i class="fas fa-check mr-2"></i>
                                                Đã nhớ
                                            </span>
                                            <span wire:loading wire:target="markReviewed">
                                                <i class="fas fa-spinner fa-spin mr-2"></i>
                                                Đang xử lý...
                                            </span>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-12">
            <i class="fas fa-check-circle text-6xl text-green-500 mb-4"></i>
            <h3 class="text-xl font-semibold text-gray-700 mb-2">Tuyệt vời!</h3>
            <p class="text-gray-500 mb-4">Hôm nay không có từ nào cần ôn tập.</p>
            <a href="{{ route('vocabulary.create') }}" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700">
                <i class="fas fa-plus mr-2"></i>
                Thêm từ mới
            </a>
        </div>
    @endif
</div>
