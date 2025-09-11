@extends('layouts.app')

@section('content')
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

        <form action="{{ route('vocabulary.update', $word) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label for="word" class="block text-sm font-medium text-gray-700 mb-2">
                        Từ vựng <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="word" name="word" value="{{ old('word', $word->word) }}" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="Ví dụ: achieve">
                    @error('word')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="part_of_speech" class="block text-sm font-medium text-gray-700 mb-2">
                        Loại từ
                    </label>
                    <select id="part_of_speech" name="part_of_speech"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Chọn loại từ</option>
                        @foreach ($partsOfSpeech as $value => $label)
                            <option value="{{ $value }}" {{ old('part_of_speech', $word->part_of_speech) == $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    @error('part_of_speech')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="pronunciation" class="block text-sm font-medium text-gray-700 mb-2">
                        Phiên âm
                    </label>
                    <input type="text" id="pronunciation" name="pronunciation" value="{{ old('pronunciation', $word->pronunciation) }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
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
                <textarea id="meaning" name="meaning" required rows="3"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="Ví dụ: đạt được, hoàn thành">{{ old('meaning', $word->meaning) }}</textarea>
                @error('meaning')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-between">
                <button type="button" onclick="if(confirm('Bạn có chắc chắn muốn xóa từ này?')) document.getElementById('delete-form').submit();"
                    class="bg-red-600 text-white px-6 py-2 rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                    <i class="fas fa-trash mr-2"></i>
                    Xóa từ
                </button>

                <div class="space-x-2">
                    <a href="{{ route('vocabulary.index') }}" class="bg-gray-500 text-white px-6 py-2 rounded-md hover:bg-gray-600">
                        Hủy
                    </a>
                    <button type="submit"
                        class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        <i class="fas fa-save mr-2"></i>
                        Cập nhật
                    </button>
                </div>
            </div>
        </form>

        <form id="delete-form" action="{{ route('vocabulary.destroy', $word) }}" method="POST" class="hidden">
            @csrf
            @method('DELETE')
        </form>
    </div>
@endsection
