@props(['user', 'person'])

<div class="flex items-center gap-6 my-6">
    @if ($user['picture'])
        <img class="w-20 h-20 rounded-full object-cover" src="{{ asset('storage/' . $user->picture) }}" alt="Profile">
    @else
        <div
            class="relative inline-flex items-center justify-center w-20 h-20 overflow-hidden bg-gray-100 rounded-full dark:bg-gray-600">
            <span
                class="font-medium text-gray-600 dark:text-gray-300">{{ $person['first_name'][0] . $person['last_name'][0] }}</span>
        </div>
    @endif
    <ul class="basis-3/5 max-w-md space-y-1 text-gray-500 list-inside dark:text-gray-400">
        <li class="flex items-center">
            <i class="fa-solid fa-envelope mr-2"></i>
            <span class="text-sm">{{ $user->email }}</span>
        </li>
        <li class="flex items-center">
            <i class="fa-solid fa-phone mr-2"></i>
            <span class="text-sm">{{ $person->phone_number }}</span>
        </li>
        <li class="flex items-center">
            <i class="fa-solid fa-location-dot mr-2"></i>
            <span class="text-sm">{{ $person->address }}</span>
        </li>
    </ul>
</div>
