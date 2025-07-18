<x-layouts.app :title="__('Analitos Carali')">

    <div class="flex w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <div
                class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <x-show_modal_graft_pie>
                </x-show_modal_graft_pie>
            </div>
            <div
                class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <x-show_modal_graft_bar>
                </x-show_modal_graft_bar>
            </div>
            <div
                class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <x-form_filter_date ruta='analyte.carali.import'>
                </x-form_filter_date>
            </div>
        </div>
        <div class="relative flex-1 p-1 overflow-hidden rounded-xl border border-neutral-900 dark:border-neutral-700">
            <div class="flex items-end gap-x-2 flex-wrap sm:flex-nowrap">
                <div>
                    <p class="mb-2">Filtrar por fecha:</p>
                    <x-form_filter_params ruta='analyte.carali'>
                    </x-form_filter_params>
                </div>
                <div>
                    <p class="mb-2">Exportar:</p>

                    <form id="export-form" method="POST" action="{{ route('analyte.carali.export') }}">
                        @csrf
                        <input type="hidden" name="exportData" id="exportData">
                    </form>

                    <button onclick="exportarTabla()">Exportar a Excel</button>
                </div>
            </div>
        </div>

        <div
            class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-900 dark:border-neutral-700">
             <div class="flex flex-col">
                <x-principal_table :grupos="$grupos" :resultados="$resultados" :tipo="'examenes'" :total="$total">
                </x-principal_table>
            </div>

        </div>
    </div>
    @if ($resultados->isEmpty())
        <div class="flex items-center justify-center h-64">
            <p class="text-gray-500 dark:text-neutral-400">No hay resultados para mostrar.</p>
        </div>
    @endif
    <!-- Modal para gráfico pie-->
    <x-modal_graft_pie>
    </x-modal_graft_pie>

    <!-- Modal para gráfico barra-->
    <x-modal_graft_bar>
    </x-modal_graft_bar>
</x-layouts.app>

<script>
    function toggleDetails(groupSlug) {
        let detailsRow = document.getElementById('details-' + groupSlug);
        if (detailsRow) {
            detailsRow.classList.toggle('hidden');
        }
    }
</script>

<script>
    document.addEventListener("livewire:navigated", function() {
        setupChartBar('myChartBar', @json($examenes->pluck('Descrip')), @json($examenes->pluck('total')), 'examenes');
        setupChartPie('myChartPie', @json($grupos->pluck('group')), @json($grupos->pluck('total')), 'examenes');
    });
</script>
<script>
    function exportarTabla() {
        const data = [];
        const rows = document.querySelectorAll('table > tbody > tr');

        let currentGroup = null;

        rows.forEach(row => {
            const isDetailContainer = row.querySelector('table');

            if (!isDetailContainer) {
                const cols = row.querySelectorAll('td');
                currentGroup = {
                    grupo: cols[0]?.innerText.trim(),
                    total: cols[1]?.innerText.trim(),
                    detalles: []
                };
                data.push(currentGroup);
            } else {
                const detailRows = row.querySelectorAll('table tbody tr');
                detailRows.forEach(detail => {
                    const cols = detail.querySelectorAll('td');
                    currentGroup.detalles.push({
                        codigo: cols[1]?.innerText.trim(),
                        descripcion: cols[2]?.innerText.trim(),
                        cantidad: cols[3]?.innerText.trim(),
                        sede: cols[4]?.innerText.trim(),
                        convenio: cols[5]?.innerText.trim()
                    });
                });
            }
        });

        document.getElementById('exportData').value = JSON.stringify(data);
        document.getElementById('export-form').submit();
    }
</script>
