<x-layouts.app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <div
                class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <div class="card">
                    <div class="card-body">
                        <div>
                            <canvas id="myChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div
                class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <x-placeholder-pattern
                    class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
            </div>
            <div
                class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <x-placeholder-pattern
                    class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
            </div>
        </div>
        <div
            class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
            
        </div>
    </div>

    <script>
        document.addEventListener("livewire:navigated", function() {
            // Verificar si el gráfico ya existe en memoria
            let chartStatus = Chart.getChart("myChart");
            if (chartStatus) {
                chartStatus.destroy(); // Si existe, destruirlo antes de crear uno nuevo
            }

            // Esperar a que el elemento canvas esté disponible
            if (document.getElementById('myChart')) {
                const ctx = document.getElementById('myChart').getContext('2d');

                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: {!! json_encode($resultado->pluck('dia')) !!},
                        datasets: [{
                            label: 'Visit for day',
                            data: {!! json_encode($resultado->pluck('total')) !!},
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            }
        });

        function toggleRow(id) {
            var row = document.getElementById(id);
            row.classList.toggle("hidden");
        }
    </script>
</x-layouts.app>
