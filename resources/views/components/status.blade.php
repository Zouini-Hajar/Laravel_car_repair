@props(['status'])

@switch($status)
    @case('Fixed')
    @case('Completed')
    @case('Paid')
        <span
            class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300">
            {{ $status }}
        </span>
    @break

    @case('In Progress')
        <span
            class="bg-blue-100 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full dark:bg-blue-900 dark:text-blue-300">
            {{ $status }}
        </span>
    @break

    @case('Waiting for Parts')
        <span
            class="bg-yellow-100 text-yellow-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full dark:bg-yellow-900 dark:text-yellow-300">
            {{ $status }}
        </span>
    @break

    @case('Not Paid')
        <span
            class="bg-purple-100 text-purple-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full dark:bg-purple-900 dark:text-purple-300">
            {{ $status }}
        </span>
    @break

    @default
        <span
            class="bg-gray-100 text-gray-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full dark:bg-gray-700 dark:text-gray-300">{{ $status }}</span>
@endswitch
