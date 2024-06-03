@extends('layout')

@php
    $headers = ['#', 'Client', 'Total', 'Status'];
    if (!$invoices->isEmpty()) {
        $columns = array_keys($invoices->first()->toArray());
    }
@endphp

@section('content')
    <div class="flex justify-between items-center my-5">
        <h3 class="text-3xl font-bold text-gray-900 dark:text-white">
            Invoices
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
        @if (!$invoices->isEmpty())
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
                    @foreach ($invoices as $item)
                        <tr onclick="window.location='{{ '/repairs' . '/' . $item->repair_id }}'"
                            class="cursor-pointer bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="px-6 py-4">
                                {{ $item->id }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $item->first_name . ' ' . $item->last_name }}
                            </td>
                            <td class="px-6 py-4 font-semibold">
                                {{ $item->total }} DH
                            </td>
                            <td class="px-6 py-4">
                                <x-status :status="$item->status" />
                            </td>
                            @if (auth()->user()->role != 'client')
                                <td class="flex justify-center items-center px-6 py-4">
                                    <button type="button" onclick="event.stopPropagation();"
                                        data-modal-target={{ 'edit-modal-' . $item->id }}
                                        data-modal-toggle={{ 'edit-modal-' . $item->id }}
                                        class="mr-1 text-purple-700 border border-purple-700 hover:bg-purple-700 hover:text-white focus:ring-4 focus:outline-none focus:ring-purple-300 font-medium rounded-full text-sm p-2.5 text-center inline-flex items-center dark:border-purple-500 dark:text-purple-500 dark:hover:text-white dark:focus:ring-purple-800 dark:hover:bg-purple-500">
                                        <i class="fa-solid fa-pen"></i>
                                    </button>
                                </td>
                            @else
                                <td class="flex justify-center items-center px-6 py-4">
                                    <button type="button" onclick="event.stopPropagation();"
                                        class="mr-1 text-purple-700 border border-purple-700 hover:bg-purple-700 hover:text-white focus:ring-4 focus:outline-none focus:ring-purple-300 font-medium rounded-full text-sm p-2.5 text-center inline-flex items-center dark:border-purple-500 dark:text-purple-500 dark:hover:text-white dark:focus:ring-purple-800 dark:hover:bg-purple-500">
                                        <i class="fa-solid fa-print"></i>
                                    </button>
                                </td>
                            @endif
                        </tr>
                        @if (auth()->user()->role != 'client')
                            <div id={{ 'edit-modal-' . $item->id }} tabindex="-1" aria-hidden="true"
                                data-modal-backdrop="static"
                                class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                <div class="relative p-4 w-2/5 max-h-full">
                                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                        <div
                                            class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                                Edit Invoice
                                            </h3>
                                            <button type="button"
                                                class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                                data-modal-hide={{ 'edit-modal-' . $item->id }}>
                                                <i class="fa-solid fa-x"></i>
                                                <span class="sr-only">Close modal</span>
                                            </button>
                                        </div>
                                        <form method="POST" action="/invoices/{{ $item->id }}">
                                            @csrf
                                            @method('PUT')
                                            <div class="p-4 md:p-5 space-y-4">
                                                <div class="mb-5">
                                                    <label for="status"
                                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                                        Status
                                                    </label>
                                                    <select id="status" name="status"
                                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-purple-500 focus:border-purple-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-purple-500 dark:focus:border-purple-500">
                                                        <option value="Paid" @selected($item->status == 'Paid')>Paid</option>
                                                        <option value="Not Paid" @selected($item->status == 'Not Paid')>Not Paid
                                                        </option>
                                                    </select>
                                                    @error('status')
                                                        <p id="filled_error_help"
                                                            class="mt-2 text-xs text-red-600 dark:text-red-400">
                                                            {{ $message }}
                                                        </p>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div
                                                class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                                                <button data-modal-hide={{ 'edit-modal-' . $item->id }} type="submit"
                                                    class="text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:outline-none focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-800">
                                                    Update
                                                </button>
                                                <button data-modal-hide={{ 'edit-modal-' . $item->id }} type="button"
                                                    class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-purple-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                                                    Cancel
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </tbody>
            </table>
            <div class="mt-6 p-4 z-50">
                {{ $invoices->links() }}
            </div>
        @else
            <div class="text-center">No Data Found</div>
        @endif
    </div>
@endsection
