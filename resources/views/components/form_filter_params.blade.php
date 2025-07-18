<div>
    <form action="{{ route($ruta) }}" method="get" class="px-1 py-1">
        @csrf
        <div class="flex items-end gap-x-2 flex-wrap sm:flex-nowrap">
            <div>
                <label for="date_start" class="text-sm">Fecha inicio</label>
                <input id="date_start" type="date" name="date_start" value="{{ request('date_start') }}"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-40 h-8 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
            </div>
            <div>
                <label for="date_end" class="text-sm">Fecha fin</label>
                <input id="date_end" type="date" name="date_end" value="{{ request('date_end') }}"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-40 h-8 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
            </div>
            <button type="submit"
                class="py-2.5 px-5 text-sm font-medium text-gray-900 bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                Filtrar
            </button>
        </div>
    </form>
</div>
