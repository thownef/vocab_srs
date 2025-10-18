<div class="bg-white rounded-lg shadow-md p-6">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">
        <i class="fas fa-list text-purple-600 mr-2"></i>
        Tất cả từ vựng
    </h1>

    <!-- Search and Filter Section -->
    <div class="mb-6 p-4 bg-gray-50 rounded-lg">
        <div class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-search mr-1"></i>Tìm kiếm
                    </label>
                    <input type="text" id="search" wire:model.live.debounce.300ms="search"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="Tìm theo từ, nghĩa, ví dụ...">
                </div>

                <div>
                    <label for="part_of_speech" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-filter mr-1"></i>Lọc theo loại từ
                    </label>
                    <select id="part_of_speech" wire:model.live="partOfSpeech"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Tất cả loại từ</option>
                        @foreach ($partsOfSpeech as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-end">
                    <button wire:click="clearFilters" type="button"
                        class="w-full bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                        <i class="fas fa-times mr-2"></i>
                        Xóa bộ lọc
                    </button>
                </div>
            </div>
        </div>

        @if ($search || $partOfSpeech)
            <div class="mt-4 p-3 bg-blue-50 rounded-md">
                <p class="text-sm text-blue-800">
                    <i class="fas fa-info-circle mr-2"></i>
                    <strong>Kết quả tìm kiếm:</strong>
                    @if ($search)
                        Từ khóa: "{{ $search }}"
                    @endif
                    @if ($partOfSpeech)
                        @if ($search)
                            |
                        @endif
                        Loại từ: {{ $partsOfSpeech[$partOfSpeech] ?? $partOfSpeech }}
                    @endif
                </p>
            </div>
        @endif
    </div>

    @if ($words->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Từ vựng
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Loại từ
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Số lần ôn
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Ngày ôn tiếp theo
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Ngày tạo
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Thao tác
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($words as $word)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $word->word }}</div>
                                @if ($word->pronunciation)
                                    <div class="text-sm text-gray-500">[{{ $word->pronunciation }}]</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($word->part_of_speech)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $word->getPartOfSpeechLabel() }}
                                    </span>
                                @else
                                    <span class="text-gray-400 text-sm">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ $word->review_count }}/6
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $word->next_review_date->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $word->created_date->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('vocabulary.edit', $word) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">
                                    <i class="fas fa-edit"></i>
                                    Sửa
                                </a>
                                <button wire:click="deleteWord({{ $word->id }})" wire:confirm="Bạn có chắc chắn muốn xóa từ này?"
                                    class="text-red-600 hover:text-red-900">
                                    <i class="fas fa-trash"></i>
                                    Xóa
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $words->links() }}
        </div>

        <div class="mt-6 flex justify-between items-center text-sm text-gray-500">
            <p>Tổng cộng: {{ $words->total() }} từ vựng</p>
            @if ($search || $partOfSpeech)
                <button wire:click="clearFilters" class="text-blue-600 hover:text-blue-800">
                    <i class="fas fa-arrow-left mr-1"></i>
                    Xem tất cả từ vựng
                </button>
            @endif
        </div>
    @else
        <div class="text-center py-12">
            @if ($search || $partOfSpeech)
                <i class="fas fa-search text-6xl text-gray-400 mb-4"></i>
                <h3 class="text-xl font-semibold text-gray-700 mb-2">Không tìm thấy từ vựng</h3>
                <p class="text-gray-500 mb-4">Không có từ vựng nào phù hợp với tiêu chí tìm kiếm của bạn.</p>
                <button wire:click="clearFilters" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Xem tất cả từ vựng
                </button>
            @else
                <i class="fas fa-book-open text-6xl text-gray-400 mb-4"></i>
                <h3 class="text-xl font-semibold text-gray-700 mb-2">Chưa có từ vựng nào</h3>
                <p class="text-gray-500 mb-4">Hãy bắt đầu bằng cách thêm từ vựng đầu tiên!</p>
                <a href="{{ route('vocabulary.create') }}" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700">
                    <i class="fas fa-plus mr-2"></i>
                    Thêm từ mới
                </a>
            @endif
        </div>
    @endif
</div>
