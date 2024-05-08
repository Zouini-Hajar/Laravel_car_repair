@props(['title', 'showButton', 'status'])

<div
    {{ $attributes->merge(['class' => 'p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700']) }}>
    <div class="flex justify-between items-center">
        <h3 class="text-2xl font-bold text-gray-900 dark:text-white">
            {{ $title }}
        </h3>
        @if (isset($showButton) && $showButton)
            <button type="button"
                class="w-10 h-10 flex justify-center items-center text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:outline-none focus:ring-purple-300 font-medium rounded-full text-sm p-2.5 dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-800">
                <i class="fa-solid fa-plus"></i>
            </button>
        @endif
        @if (isset($status))
            <x-status :status="$status" />
        @endif
    </div>
    <hr class="my-4">
    {{ $slot }}
</div>
