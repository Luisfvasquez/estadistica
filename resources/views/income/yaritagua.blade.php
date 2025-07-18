<x-layouts.app :title="__('Ingresos Yaritagua')">

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
                <x-form_filter_date ruta='facture.yaritagua.imports'>
                </x-form_filter_date>
            </div>
        </div>
        <div class="relative flex-1 p-1 overflow-hidden rounded-xl border border-neutral-900 dark:border-neutral-700">
            <p class="mb-2">Filtrar por fecha:</p>
            <x-form_filter_params ruta='facture.yaritagua'>
                    </x-form_filter_params>
        </div>

        <div
            class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-900 dark:border-neutral-700">
           <div class="flex flex-col">
                <x-principal_table :grupos="$grupos" :resultados="$resultados" :tipo="'ingresos'" :total="$total">
                </x-principal_table>
            </div>

        </div>
    </div>  @if ($resultados->isEmpty())
        <div class="flex items-center justify-center h-64">
            <p class="text-gray-500 dark:text-neutral-400">No hay resultados para mostrar.</p>
        </div>        
    @endif
   <!-- Modal para gráfico pie-->
    <x-modal_graft_pie >
    </x-modal_graft_pie >
    
    <!-- Modal para gráfico barra-->
    <x-modal_graft_bar >
    </x-modal_graft_bar >
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
        setupChartBar('myChartBar', @json($examenes->pluck('Descrip')), @json($examenes->pluck('total')), 'ingresos');
        setupChartPie('myChartPie', @json($grupos->pluck('group')), @json($grupos->pluck('total')), 'ingresos');
    });
</script>
