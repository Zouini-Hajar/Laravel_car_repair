@props(['route', 'title', 'headers', 'columns', 'list'])


<div class="flex justify-between items-center my-5">
    <h3 class="text-3xl font-bold text-gray-900 dark:text-white">
        {{ $title }}
    </h3>
    <div class="w-1/2 flex items-center gap-2">
        <x-search-input />
        <button type="button"
            class="px-5 py-3 text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">
            <i class="fa-solid fa-filter text-purple-700"></i> Filter
        </button>
        <button type="button" onclick="window.location='{{ $route . '/create' }}'"
            class="px-5 py-3 focus:outline-none text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:ring-purple-300 font-medium rounded-lg text-sm dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-900">
            <i class="fa-solid fa-plus"></i> Create
        </button>
    </div>
</div>
<div class="relative overflow-x-auto">
    @if (!$list->isEmpty())
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                <tr>
                    @if (in_array('picture', $columns))
                        <th class="w-24"></th>
                    @endif
                    @foreach ($headers as $header)
                        <th scope="col" class="px-6 py-3">
                            {{ $header }}
                        </th>
                    @endforeach
                    <th scope="col" class="px-6 py-3 text-center">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($list as $item)
                    <tr onclick="window.location='{{ $route . '/' . $item->id }}'"
                        class="cursor-pointer bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        @if (in_array('picture', $columns))
                            <td class="text-center">
                                @if ($item['picture'])
                                    <img class="w-10 h-10 rounded-full object-cover m-auto" src="{{ asset('storage/' . $item->picture) }}"
                                        alt="Profile">
                                @else
                                    <div
                                        class="relative inline-flex items-center justify-center w-10 h-10 overflow-hidden bg-gray-100 rounded-full dark:bg-gray-600">
                                        <span
                                            class="font-medium text-gray-600 dark:text-gray-300">{{ $item['first_name'][0] . $item['last_name'][0] }}</span>
                                    </div>
                                @endif
                            </td>
                        @endif
                        @foreach ($columns as $col)
                            @if ($col != 'id' && $col != 'picture')
                                <td class="px-6 py-4">
                                    {{ $item[$col] }}
                                </td>
                            @endif
                        @endforeach
                        <td class="flex justify-center items-center px-6 py-4">
                            <button type="button" onclick="window.location='{{ $route . '/' . $item->id . '/edit' }}'"
                                class="mr-1 text-purple-700 border border-purple-700 hover:bg-purple-700 hover:text-white focus:ring-4 focus:outline-none focus:ring-purple-300 font-medium rounded-full text-sm p-2.5 text-center inline-flex items-center dark:border-purple-500 dark:text-purple-500 dark:hover:text-white dark:focus:ring-purple-800 dark:hover:bg-purple-500">
                                <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    fill="currentColor" viewBox="0 0 512 512">
                                    <path
                                        d="M362.7 19.3L314.3 67.7 444.3 197.7l48.4-48.4c25-25 25-65.5 0-90.5L453.3 19.3c-25-25-65.5-25-90.5 0zm-71 71L58.6 323.5c-10.4 10.4-18 23.3-22.2 37.4L1 481.2C-1.5 489.7 .8 498.8 7 505s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L421.7 220.3 291.7 90.3z" />
                                </svg>
                            </button>
                            <button type="button"
                                class="text-red-700 border border-red-700 hover:bg-red-700 hover:text-white focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-full text-sm p-2.5 text-center inline-flex items-center dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:focus:ring-red-800 dark:hover:bg-red-500">
                                <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    fill="currentColor" viewBox="0 0 448 512">
                                    <path
                                        d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z" />
                                </svg>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-6 p-4 z-50">
            {{ $list->links() }}
        </div>
    @else
        <div class="text-center">No Data Found</div>
    @endif

</div>
