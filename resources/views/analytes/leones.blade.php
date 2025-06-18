<x-layouts.app :title="__('Analitos Carali')">

    <div class="flex w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <div
                class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <div class="relative w-full h-60 md:h-full" onclick="showChartModalPie()">
                    <canvas id="myChartPie" class="absolute inset-0 w-full h-full cursor-pointer"></canvas>
                </div>
            </div>
            <div
                class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <div class="relative w-100 h-full md:h-full" onclick="showChartModalBar()">
                    <canvas id="myChartBar" class="absolute inset-0 w-full h-full cursor-pointer"></canvas>
                </div>
            </div>
            <div
                class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <form action="{{ route('analyte.import') }}" method="post" enctype="multipart/form-data"
                    class="px-1 py-1">
                    @csrf
                    <p>Fecha inicio</p>
                    <input datepicker id="default-datepicker" type="date" name="date_start" required
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-40 h-8 ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Select date">
                    <p>Fecha fin</p>
                    <input type="date" name="date_end" required
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-40 h-8 ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Select date" required>
                    <input type="file" name="file" accept=".xml,application/xml,text/xml" required
    class="mt-2 mb-2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full h-8 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
<button type="submit"
                        class="py-2.5 px-5 me-2 mb-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Importar</button>
                </form>
            </div>
        </div>
        <div class="relative flex-1 p-1 overflow-hidden rounded-xl border border-neutral-900 dark:border-neutral-700">
            <p class="mb-2">Filtrar por fecha:</p>
            <form action="{{ route('analyte.leones') }}" method="get" class="px-1 py-1">
                @csrf
                <div class="flex items-end gap-x-2 flex-wrap sm:flex-nowrap">
                    <div>
                        <label for="date_start" class="text-sm">Fecha inicio</label>
                        <input id="date_start" type="date" name="date_start"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-40 h-8 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                            >
                    </div>
                    <div>
                        <label for="date_end" class="text-sm">Fecha fin</label>
                        <input id="date_end" type="date" name="date_end"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-40 h-8 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                            >
                    </div>
                    <button type="submit"
                        class="py-2.5 px-5 text-sm font-medium text-gray-900 bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                        Filtrar
                    </button>
                </div>
            </form>
        </div>

        <div
            class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-900 dark:border-neutral-700">
            <div class="flex flex-col">
                <div class="-m-1.5 overflow-x-auto">
                    <div class="p-1.5 min-w-full inline-block align-middle">
                        <div class="overflow-hidden">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-neutral-700 text-sm">
                                <thead>
                                    <tr>
                                        <th scope="col"
                                            class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">
                                            Grupo</th>
                                      <th scope="col"
                                                class="px-6 py-3 text-start text-xs font-medium text-gray-100 uppercase dark:text-neutral-100">
                                                Total Examenes: {{$total}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($grupos as $grupo)
                                        <tr class="cursor-pointer"
                                            onclick="toggleDetails('{{ Str::slug($grupo->group, '_') }}')">
                                            <td
                                                class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-200 dark:text-neutral-200">
                                                {{ $grupo->group }}
                                            </td>
                                            <td
                                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-200 dark:text-neutral-200">
                                                {{ $grupo->total }}
                                            </td>
                                        </tr>
                                        <tr id="details-{{ Str::slug($grupo->group, '_') }}" class="hidden">
                                            <td colspan="2"
                                                class="whitespace-nowrap text-sm font-medium text-gray-200 dark:text-neutral-200 dark:bg-neutral-900">
                                                <table class="min-w-full text-xs text-left">
                                                    <thead>
                                                        <tr>
                                                            <th class="px-6 py-2"></th>
                                                            <th class="px-6 py-2">Código</th>
                                                            <th class="px-6 py-2">Descripción</th>
                                                            <th class="px-6 py-2">Cantidad</th>
                                                            <th class="px-6 py-2">Sede</th>
                                                            <th class="px-6 py-2">Convenio</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="text-gray-100 ">
                                                        @foreach ($resultados->where('group', $grupo->group) as $detalle)
                                                            <tr
                                                                class="border-t border-neutral-700 dark:border-neutral-100 ">
                                                                <td class="px-6 py-2 "></td>
                                                                <td class="px-6 py-2">{{ $detalle->idcodigo }}</td>
                                                                <td class="px-6 py-2">{{ $detalle->descrip }}</td>
                                                                <td class="px-6 py-2">{{ $detalle->totexa }}</td>
                                                                <td class="px-6 py-2">{{ $detalle->sede }}</td>
                                                                <td class="px-6 py-2">{{ $detalle->convenio }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- Modal para gráfico -->
    <div id="chartModalPie" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-60 hidden ">
        <div
            class="bg-neutral-300 dark:bg-neutral-900 border border-neutral-300 dark:border-neutral-700 shadow-xl p-6 rounded-xl w-[100px] h-[600px] md:w-4/5 lg:w-3/4 relative">
            <button onclick="closeModalPie()"
                class="absolute top-2 right-2 w-8 h-8 flex items-center justify-center rounded-full bg-red-400 hover:bg-red-200 text-white text-xl font-bold transition">
                &times;
            </button>

            <canvas id="enlargedChartPie" class="w-full h-[400px]"></canvas>
        </div>
    </div>
    <div id="chartModalBar" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-60 hidden ">
        <div
            class="bg-neutral-300 dark:bg-neutral-900 border border-neutral-300 dark:border-neutral-700 shadow-xl p-6 rounded-xl w-full h-[600px] md:w-4/5 lg:w-3/4 relative">
            <button onclick="closeModalBar()"
                class="absolute top-2 right-2 w-8 h-8 flex items-center justify-center rounded-full bg-red-400 hover:bg-red-200 text-white text-xl font-bold transition">
                &times;
            </button>

            <canvas id="enlargedChartBar" class="w-full h-[400px]"></canvas>
        </div>
    </div>
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
        setupChartBar('myChartBar', @json($examenes->pluck('Descrip')), @json($examenes->pluck('total')),'examenes');
        setupChartPie('myChartPie', @json($grupos->pluck('group')), @json($grupos->pluck('total')),'examenes');
    });
</script>
