<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">
            <i class="fas fa-edit text-orange-600 mr-2"></i>
            Chỉnh sửa từ vựng
        </h1>
        <a href="{{ route('vocabulary.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">
            <i class="fas fa-arrow-left mr-2"></i>
            Quay lại
        </a>
    </div>

    <form wire:submit.prevent="update" class="space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label for="word" class="block text-sm font-medium text-gray-700 mb-2">
                    Từ vựng <span class="text-red-500">*</span>
                </label>
                <input type="text" id="word" wire:model="wordText"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('wordText') border-red-500 @enderror"
                    placeholder="Ví dụ: achieve">
                @error('wordText')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="part_of_speech" class="block text-sm font-medium text-gray-700 mb-2">
                    Loại từ
                </label>
                <select id="part_of_speech" wire:model="partOfSpeech"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('partOfSpeech') border-red-500 @enderror">
                    <option value="">Chọn loại từ</option>
                    @foreach ($partsOfSpeech as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </select>
                @error('partOfSpeech')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="pronunciation" class="block text-sm font-medium text-gray-700 mb-2">
                    Phiên âm
                </label>
                <input type="text" id="pronunciation" wire:model="pronunciation"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('pronunciation') border-red-500 @enderror"
                    placeholder="Ví dụ: /əˈtʃiːv/">
                @error('pronunciation')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div>
            <label for="meaning" class="block text-sm font-medium text-gray-700 mb-2">
                Nghĩa <span class="text-red-500">*</span>
            </label>
            <textarea id="meaning" wire:model="meaning" rows="3"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('meaning') border-red-500 @enderror"
                placeholder="Ví dụ: đạt được, hoàn thành"></textarea>
            @error('meaning')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-between">
            <button type="button" wire:click="delete" wire:confirm="Bạn có chắc chắn muốn xóa từ này?"
                class="bg-red-600 text-white px-6 py-2 rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                <i class="fas fa-trash mr-2"></i>
                Xóa từ
            </button>

            <div class="space-x-2">
                <a href="{{ route('vocabulary.index') }}" class="bg-gray-500 text-white px-6 py-2 rounded-md hover:bg-gray-600">
                    Hủy
                </a>
                <button type="submit"
                    class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:opacity-50"
                    wire:loading.attr="disabled">
                    <span wire:loading.remove>
                        <i class="fas fa-save mr-2"></i>
                        Cập nhật
                    </span>
                    <span wire:loading>
                        <i class="fas fa-spinner fa-spin mr-2"></i>
                        Đang cập nhật...
                    </span>
                </button>
            </div>
        </div>
    </form>
</div>
