@props(['title', 'route'])

<div class="flex justify-between items-center my-5">
    <div class="flex items-center gap-4">
        <button type="button" onclick="history.back()"
            class="text-purple-700 hover:bg-gray-200 focus:outline-none font-medium rounded-full text-sm p-2.5 text-center inline-flex items-center">
            <i class="fa-solid fa-arrow-left"></i>
        </button>
        <h3 class="text-3xl font-bold text-gray-900 dark:text-white">
            {{ $title }}
        </h3>
    </div>
    <button type="button"
        class="px-6 py-3 focus:outline-none text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:ring-purple-300 font-medium rounded-lg text-sm dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-900">
        <i class="fa-solid fa-pen"></i> Edit
    </button>
</div>
<hr class="mb-5">
