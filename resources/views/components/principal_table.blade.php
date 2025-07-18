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
                            class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">
                            Total {{ $tipo }} por grupo</th>
                        <th scope="col"
                            class="px-6 py-3 text-start text-xs font-medium text-gray-100 uppercase dark:text-neutral-100">
                            Total {{ $tipo }}: {{ $total }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($grupos as $grupo)
                        <tr class="cursor-pointer" onclick="toggleDetails('{{ Str::slug($grupo->group, '_') }}')">
                            <td
                                class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-200 dark:text-neutral-200">
                                {{ $grupo->group }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-200 dark:text-neutral-200">
                                {{ $grupo->total }}
                            </td>
                        </tr>
                        <tr id="details-{{ Str::slug($grupo->group, '_') }}" class="hidden">
                            <td colspan="3"
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
                                            <tr class="border-t border-neutral-700 dark:border-neutral-100 ">
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
