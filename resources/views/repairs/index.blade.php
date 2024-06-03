@extends('layout')

@php
    $headers = ['#', 'Description', 'Status', 'Start Date', 'End Date'];
    $columns = array_keys($repairs->first()->toArray());
@endphp

@section('content')
    <div class="flex justify-between items-center my-5">
        <h3 class="text-3xl font-bold text-gray-900 dark:text-white">
            Tasks
        </h3>
        <div class="w-1/2 flex items-center gap-2">
            <x-search-input />
            <button type="button"
                class="px-5 py-3 text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">
                <i class="fa-solid fa-filter text-purple-700"></i> Filter
            </button>
        </div>
    </div>
    <div class="relative overflow-x-auto">
        @if (!$repairs->isEmpty())
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <tr>
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
                    @foreach ($repairs as $item)
                        <tr onclick="window.location='{{ '/repairs' . '/' . $item->id }}'"
                            class="cursor-pointer bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            @foreach ($columns as $col)
                                <td class="px-6 py-4">
                                    @if ($col == 'status')
                                        <x-status :status="$item[$col]" />
                                    @else
                                            {{ $item[$col] ? $item[$col] : 'Not specified' }}
                                    @endif
                                </td>
                            @endforeach
                            <td class="flex justify-center items-center px-6 py-4">
                                <button type="button" onclick="event.stopPropagation();" data-modal-target={{ 'edit-modal-' . $item->id }}
                                    data-modal-show={{ 'edit-modal-' . $item->id }}
                                    class="mr-1 text-purple-700 border border-purple-700 hover:bg-purple-700 hover:text-white focus:ring-4 focus:outline-none focus:ring-purple-300 font-medium rounded-full text-sm p-2.5 text-center inline-flex items-center dark:border-purple-500 dark:text-purple-500 dark:hover:text-white dark:focus:ring-purple-800 dark:hover:bg-purple-500">
                                    <i class="fa-solid fa-pen"></i>
                                </button>
                                <button type="button" onclick="event.stopPropagation();" data-modal-target="delete-modal"
                                    data-modal-toggle="delete-modal"
                                    class="text-red-700 border border-red-700 hover:bg-red-700 hover:text-white focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-full text-sm p-2.5 text-center inline-flex items-center dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:focus:ring-red-800 dark:hover:bg-red-500">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <x-edit-repair-modal :target="'edit-modal-' . $item->id" :mechanics="$mechanics" :repair="$item" />
                        <x-delete-modal :id="$item->id" route="/repairs" />
                    @endforeach
                </tbody>
            </table>
            <div class="mt-6 p-4 z-50">
                {{ $repairs->links() }}
            </div>
        @else
            <div class="text-center">No Data Found</div>
        @endif
    </div>
@endsection
