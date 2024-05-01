@props(['title'])

<div {{ $attributes->merge(['class' => 'p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700'])}}>
    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">
        {{ $title }}
    </h3>
    <hr class="my-3">
    {{ $slot }}
</div>
