<div>
    <form action="{{ route($ruta) }}" method="post" enctype="multipart/form-data" class="px-1 py-1">
        @csrf
        <label for="date_start" class="text-sm">Fecha inicio</label>
        <input id="date_start" type="date" name="date_start" required
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-40 h-8 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
        <label for="date_end" class="text-sm">Fecha fin</label>
        <input id="date_end" type="date" name="date_end" required
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-40 h-8 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
        <input type="file" name="file" accept=".xml,application/xml,text/xml" required
            class="mt-2 mb-2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full h-8 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
        <button type="submit"
            class="py-2.5 px-5 me-2 mb-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Importar</button>
    </form>
</div>
