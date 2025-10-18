<div class="bg-white rounded-lg shadow-md p-6">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">
        <i class="fas fa-chart-bar text-emerald-600 mr-2"></i>
        Tổng kết học tập
    </h1>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="col-span-1 bg-gray-50 p-4 rounded flex items-center justify-between">
            <div class="flex items-center gap-1">
                <div class="text-xs text-gray-500">Tổng số từ: </div>
                <div class="text-xl font-bold text-gray-900">{{ number_format($totalWords) }}</div>
            </div>
        </div>

        <div class="col-span-1 lg:col-span-2 bg-gray-50 p-3 rounded">
            <canvas id="reviewDistChart" height="160"></canvas>
            <div id="reviewLegend" class="mt-2 grid grid-cols-1 md:grid-cols-3 gap-1 text-xs"></div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
    document.addEventListener('livewire:navigated', function() {
        initChart();
    });

    document.addEventListener('DOMContentLoaded', function() {
        initChart();
    });

    function initChart() {
        const reviewLabels = @json($reviewLabels);
        const reviewData = @json($reviewData);
        const total = @json($totalWords);

        const colors = ['#EF4444', '#F97316', '#F59E0B', '#22C55E', '#06B6D4', '#6366F1'];

        const ctx = document.getElementById('reviewDistChart');
        if (ctx) {
            // Destroy existing chart if it exists
            const existingChart = Chart.getChart(ctx);
            if (existingChart) {
                existingChart.destroy();
            }

            new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: reviewLabels,
                    datasets: [{
                        data: reviewData,
                        backgroundColor: reviewLabels.map((_, i) => colors[i % colors.length]),
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    aspectRatio: 2.2,
                    layout: {
                        padding: 0
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: (context) => {
                                    const value = context.parsed || 0;
                                    const pct = total ? ((value / total) * 100).toFixed(1) : '0.0';
                                    return `${context.label}: ${value} (${pct}%)`;
                                }
                            }
                        },
                        legend: {
                            display: false
                        }
                    }
                }
            });

            const legend = document.getElementById('reviewLegend');
            if (legend) {
                const items = reviewLabels.map((label, i) => {
                    const value = reviewData[i] || 0;
                    const pct = total ? ((value / total) * 100).toFixed(1) : '0.0';
                    return `
                        <div class="flex items-center">
                            <span class="inline-block w-3 h-3 mr-2 rounded-sm" style="background:${colors[i % colors.length]}"></span>
                            <span class="text-gray-700">${label}:</span>
                            <span class="ml-1 font-medium text-gray-900">${value}</span>
                            <span class="ml-1 text-gray-500">(${pct}%)</span>
                        </div>
                    `;
                }).join('');
                legend.innerHTML = items;
            }
        }
    }
</script>
