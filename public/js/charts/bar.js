// charts.js en public/js

let originalChartData = null;

function setupChartBar(canvasId, labels, data) {
    const ctx = document.getElementById(canvasId)?.getContext('2d');
    if (!ctx) return;

    const chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels,
            datasets: [{
                label: 'Cantidad de examenes',
                data,
                backgroundColor: generateColors(data.length), // 🔥 agregamos colores
                borderWidth: 1
            }]
        },

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

    if (canvasId === 'myChartBar') {
        originalChartDataBar = JSON.parse(JSON.stringify({ data: chart.data, options: chart.options }));
    }
}

function showChartModalBar() {
    document.getElementById('chartModalBar')?.classList.remove('hidden');

    const canvas = document.getElementById('enlargedChartBar');
    if (!canvas || !originalChartDataBar) return;

    Chart.getChart(canvas)?.destroy();

    const ctx = canvas.getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: originalChartDataBar.data,
        options: originalChartDataBar.options
    });
}

function closeModalBar() {
    document.getElementById('chartModalBar')?.classList.add('hidden');
}
function generateColors(count) {
    const colors = [
        '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0',
        '#9966FF', '#FF9F40', '#66BB6A', '#BA68C8',
        '#FFD54F', '#E57373', '#81C784', '#64B5F6'
    ];
    return Array.from({ length: count }, (_, i) => colors[i % colors.length]);
}