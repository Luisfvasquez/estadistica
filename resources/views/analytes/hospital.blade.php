<x-layouts.app :title="__('Analitos Hospital')">

    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <div
                class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <form action="{{ route('analyte.import') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="file" accept=".xlsx, .xls, .csv" required>
                    <button type="submit">Importar</button>
                </form>
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
            class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-900 dark:border-neutral-700">
            <div class="flex flex-col">
                <div class="-m-1.5 overflow-x-auto">
                    <div class="p-1.5 min-w-full inline-block align-middle">
                        <div class="overflow-hidden">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-neutral-700 text-sm">
                                <thead>
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">Grupo</th>
                                        <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">Total Exámenes</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($grupos as $grupo)
                                    <tr class="cursor-pointer" onclick="toggleDetails('{{ Str::slug($grupo->group, '_') }}')">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-200 dark:text-neutral-200">
                                            {{ $grupo->group }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-200 dark:text-neutral-200">
                                            {{ $grupo->total }}
                                        </td>
                                    </tr>
                                    <tr id="details-{{ Str::slug($grupo->group, '_') }}" class="hidden">
                                        <td colspan="2" class="whitespace-nowrap text-sm font-medium text-gray-200 dark:text-neutral-200 dark:bg-neutral-900">
                                            <table class="min-w-full text-xs text-left">
                                                <thead>
                                                    <tr>
                                                        <th class="px-6 py-2">TipExa1</th>
                                                        <th class="px-6 py-2">Código</th>
                                                        <th class="px-6 py-2">Descripción</th>
                                                        <th class="px-6 py-2">TotExa</th>
                                                        <th class="px-6 py-2">Sede</th>
                                                        <th class="px-6 py-2">Convenio</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="text-gray-100 ">
                                                    @foreach ($resultados->where('group', $grupo->group) as $detalle)
                                                    <tr class="border-t border-neutral-700 dark:border-neutral-100 ">
                                                        <td class="px-6 py-2 ">{{ $detalle->tipexa1 }}</td>
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

</x-layouts.app>
<script>
function toggleDetails(groupSlug) {
    let detailsRow = document.getElementById('details-' + groupSlug);
    if (detailsRow) {
        detailsRow.classList.toggle('hidden');
    }
}
</script>
