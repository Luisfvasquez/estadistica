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
