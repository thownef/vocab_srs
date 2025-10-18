<!DOCTYPE html>
<html lang="vi">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Smart Repeat - Học tiếng Anh</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
        @livewireStyles
    </head>

    <body class="bg-gray-50">
        <nav class="bg-blue-600 text-white shadow-lg">
            <div class="max-w-6xl mx-auto px-4">
                <div class="flex justify-between items-center py-4">
                    <div class="text-xl font-bold">
                        <i class="fas fa-brain mr-2"></i>
                        Smart Repeat
                    </div>
                    <div class="space-x-4">
                        <a href="{{ route('vocabulary.create') }}" class="hover:text-blue-200">
                            <i class="fas fa-plus mr-1"></i>Thêm từ mới
                        </a>
                        <a href="{{ route('vocabulary.review') }}" class="hover:text-blue-200">
                            <i class="fas fa-calendar-day mr-1"></i>Ôn tập hôm nay
                        </a>
                        <a href="{{ route('vocabulary.index') }}" class="hover:text-blue-200">
                            <i class="fas fa-list mr-1"></i>Tất cả từ vựng
                        </a>
                        <a href="{{ route('vocabulary.summary') }}" class="hover:text-blue-200">
                            <i class="fas fa-chart-pie mr-1"></i>Tổng kết
                        </a>
                    </div>
                </div>
            </div>
        </nav>

        <main class="max-w-4xl mx-auto px-4 py-8">
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            {{ $slot }}
        </main>

        @livewireScripts
    </body>

</html>
