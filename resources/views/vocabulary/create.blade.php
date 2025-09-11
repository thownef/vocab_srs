@extends('layouts.app')

@section('content')
    <div class="bg-white rounded-lg shadow-md p-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">
            <i class="fas fa-plus-circle text-blue-600 mr-2"></i>
            Thêm từ vựng mới
        </h1>

        <form action="{{ route('vocabulary.store') }}" method="POST" class="space-y-4">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label for="word" class="block text-sm font-medium text-gray-700 mb-2">
                        Từ vựng <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="word" name="word"
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
                            <option value="{{ $value }}">{{ $label }}</option>
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
                    <input type="text" id="pronunciation" name="pronunciation"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="Ví dụ: /əˈtʃiːv/">
                </div>
            </div>

            <div>
                <label for="meaning" class="block text-sm font-medium text-gray-700 mb-2">
                    Nghĩa <span class="text-red-500">*</span>
                </label>
                <textarea id="meaning" name="meaning" rows="3"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="Ví dụ: đạt được, hoàn thành"></textarea>
            </div>

            <div class="flex justify-end">
                <button type="submit"
                    class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    <i class="fas fa-save mr-2"></i>
                    Thêm từ
                </button>
            </div>
        </form>

        <div class="mt-8 p-4 bg-blue-50 rounded-lg">
            <h3 class="font-semibold text-blue-800 mb-2">
                <i class="fas fa-info-circle mr-2"></i>
                Lịch ôn tập Spaced Repetition
            </h3>
            <ul class="text-sm text-blue-700 space-y-1">
                <li>• Ngày 1: Học từ mới</li>
                <li>• Ngày 1 (tối): Ôn lại lần 1</li>
                <li>• Ngày 2: Ôn lại lần 2</li>
                <li>• Ngày 4: Ôn lại lần 3</li>
                <li>• Ngày 8: Ôn lại lần 4</li>
                <li>• Ngày 15: Ôn lại lần 5</li>
                <li>• Ngày 30: Ôn lại lần 6</li>
            </ul>
        </div>
    </div>
@endsection
