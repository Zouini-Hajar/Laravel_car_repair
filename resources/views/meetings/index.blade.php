@extends('layout')

@php
    $roleHeaders = [
        'client' => ['#', 'Mechanic', 'Date', 'Time', 'Status'],
        'mechanic' => ['#', 'Client', 'Date', 'Time', 'Status'],
        'admin' => ['#', 'Mechanic', 'Client', 'Date', 'Time', 'Status'],
    ];

    $headers = $roleHeaders[auth()->user()->role];

    if (!$meetings->isEmpty()) {
        $columns = array_keys($meetings->first()->toArray());
    }
@endphp

@section('content')
    <div class="flex justify-between items-center my-5">
        <h3 class="text-3xl font-bold text-gray-900 dark:text-white">
            Meetings
        </h3>
        <div class="w-1/2 flex items-center gap-2">
            <x-search-input route="meetings" />
        </div>
    </div>
    <div class="relative overflow-x-auto">
        @if (!$meetings->isEmpty())
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <tr>
                        @foreach ($headers as $header)
                            <th scope="col" class="px-6 py-3">
                                {{ $header }}
                            </th>
                        @endforeach
                        {{-- <th scope="col" class="px-6 py-3 text-center">
                            Actions
                        </th> --}}
                    </tr>
                </thead>
                <tbody>
                    @foreach ($meetings as $item)
                        <tr
                            class="cursor-pointer bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="px-6 py-4">
                                {{ $item->id }}
                            </td>
                            <td class="px-6 py-4">
                                {{ auth()->user()->role == 'mechanic' ? $item->client : $item->mechanic }}
                            </td>
                            @if (auth()->user()->role == 'admin')
                                <td class="px-6 py-4">
                                    {{ $item->client }}
                                </td>
                            @endif
                            <td class="px-6 py-4 font-semibold">
                                {{ $item->date }}
                            </td>
                            <td class="px-6 py-4 font-semibold">
                                {{ $item->time }}
                            </td>
                            <td class="px-6 py-4">
                                <x-status :status="$item->status" />
                            </td>
                            {{-- <td class="flex justify-center items-center px-6 py-4">
                                <button type="button" data-modal-target={{ 'cancel-modal-' . $item->id }}
                                    data-modal-toggle={{ 'cancel-modal-' . $item->id }}
                                    class="mr-1 text-red-700 border border-red-700 hover:bg-red-700 hover:text-white focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-full text-sm p-2.5 text-center inline-flex items-center dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:focus:ring-red-800 dark:hover:bg-red-500">
                                    <i class="fa-solid fa-minus"></i>
                                </button>
                            </td> --}}
                        </tr>
                        {{-- <div id={{ 'cancel-modal-' . $item->id }} tabindex="-1"
                            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                            <div class="relative p-4 w-full max-w-md max-h-full">
                                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                    <button type="button"
                                        class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                        data-modal-hide={{ 'cancel-modal-' . $item->id }}>
                                        <i class="fa-solid fa-x"></i>
                                        <span class="sr-only">Close modal</span>
                                    </button>
                                    <div class="p-4 md:p-5 text-center">
                                        <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200"
                                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 20 20">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                        </svg>
                                        <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">
                                            Are you sure you want to cancel this meeting?
                                        </h3>
                                        <form method="POST" action="/meetings/{{ $item->id }}">
                                            @csrf
                                            @method('DELETE')
                                            <button data-modal-hide={{ 'cancel-modal-' . $item->id }} type="submit"
                                                class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                                                Yes, I'm sure
                                            </button>
                                        </form>
                                        <button data-modal-hide={{ 'cancel-modal-' . $item->id }} type="button"
                                            class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-purple-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">No,
                                            cancel
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                    @endforeach
                </tbody>
            </table>
            <div class="mt-6 p-4 z-50">
                {{ $meetings->links() }}
            </div>
        @else
            <div class="text-center">No Data Found</div>
        @endif
    </div>
@endsection
