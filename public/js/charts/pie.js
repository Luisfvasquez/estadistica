// charts.js en public/js

let originalChartData = null;

function setupChartPie(canvasId, labels, data) {
    const ctx = document.getElementById(canvasId)?.getContext('2d');
    if (!ctx) return;

    const chart = new Chart(ctx, {
        type: 'doughnut',
        data: { labels, datasets: [{ data, borderWidth: 1 }] },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    if (canvasId === 'myChartPie') {
        originalChartDataPie = JSON.parse(JSON.stringify({ data: chart.data, options: chart.options }));
    }
}

function showChartModalPie() {
    document.getElementById('chartModalPie')?.classList.remove('hidden');

    const canvas = document.getElementById('enlargedChartPie');
    if (!canvas || !originalChartDataPie) return;

    Chart.getChart(canvas)?.destroy();

    const ctx = canvas.getContext('2d');
    new Chart(ctx, {
        type: 'doughnut',
        data: originalChartDataPie.data,
        options: originalChartDataPie.options
    });
}
function closeModalPie() {
    document.getElementById('chartModalPie')?.classList.add('hidden');
}
