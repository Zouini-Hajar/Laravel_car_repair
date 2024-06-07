@extends('layout')

@php
    $headers = ['Name', 'Reference', 'Stock', 'Price'];
    $columns = array_keys($spareparts->first()->toArray());
@endphp

@section('content')
    <div class="flex justify-between items-center my-5">
        <h3 class="text-3xl font-bold text-gray-900 dark:text-white">
            Spare Parts
        </h3>
        <div class="w-3/5 flex items-center gap-2">
            <x-search-input route="spareparts" />
            @if (auth()->user()->role == 'admin')
                <button type="button" onclick="window.location='spareparts-export'"
                    class="px-5 py-3 text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">
                    <i class="fa-solid fa-upload text-purple-700"></i> Export
                </button>
                <button type="button" data-modal-target="import-modal" data-modal-show="import-modal"
                    class="px-5 py-3 text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">
                    <i class="fa-solid fa-download text-purple-700"></i> Import
                </button>
            @endif
            <button type="button" data-modal-target="create-modal" data-modal-show="create-modal"
                class="px-5 py-3 focus:outline-none text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:ring-purple-300 font-medium rounded-lg text-sm dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-900">
                <i class="fa-solid fa-plus"></i> Create
            </button>
        </div>
    </div>
    <div class="relative overflow-x-auto">
        @if (!$spareparts->isEmpty())
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
                    @foreach ($spareparts as $item)
                        <tr data-modal-target={{ 'edit-modal-' . $item->id }}
                            data-modal-show={{ 'edit-modal-' . $item->id }}
                            class="cursor-pointer bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="text-center">
                                <img class="w-10 h-10 rounded-full object-cover m-auto"
                                    src="{{ asset('storage/' . $item->picture) }}" alt="Sparepart">
                            </td>
                            @foreach ($columns as $col)
                                @if ($col != 'id' && $col != 'supplier_id' && $col != 'picture')
                                    <td class="px-6 py-4">
                                        {{ $item[$col] }}
                                    </td>
                                @endif
                            @endforeach
                            <td class="flex justify-center items-center px-6 py-4">
                                <button type="button" data-modal-target="edit-modal" data-modal-show="edit-modal"
                                    class="mr-1 text-purple-700 border border-purple-700 hover:bg-purple-700 hover:text-white focus:ring-4 focus:outline-none focus:ring-purple-300 font-medium rounded-full text-sm p-2.5 text-center inline-flex items-center dark:border-purple-500 dark:text-purple-500 dark:hover:text-white dark:focus:ring-purple-800 dark:hover:bg-purple-500">
                                    <i class="fa-solid fa-pen"></i>
                                </button>
                                <button type="button" onclick="event.stopPropagation();" data-modal-target="delete-modal"
                                    data-modal-toggle="delete-modal"
                                    class="text-red-700 border border-red-700 hover:bg-red-700 hover:text-white focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-full text-sm p-2.5 text-center inline-flex items-center dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:focus:ring-red-800 dark:hover:bg-red-500">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </td>
                            <x-delete-modal :id="$item->id" route="/spareparts" />
                            <x-edit-sparepart-modal :sparepart="$item" :suppliers="$suppliers" />
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-6 p-4 z-50">
                {{ $spareparts->links() }}
            </div>
            @if (auth()->user()->role == 'admin')
                <div id='import-modal' tabindex="-1" aria-hidden="true" data-modal-backdrop="static"
                    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                    <div class="relative p-4 w-2/5 max-h-full">
                        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                            <div
                                class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                    Import File
                                </h3>
                                <button type="button"
                                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                    data-modal-hide='import-modal'>
                                    <i class="fa-solid fa-x"></i>
                                    <span class="sr-only">Close modal</span>
                                </button>
                            </div>
                            <form method="POST" action="spareparts-import" enctype="multipart/form-data">
                                @csrf
                                <div class="p-4 md:p-5 space-y-4">
                                    <div class="mb-5">
                                        <label for="file"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                            Choose file
                                        </label>
                                        <input name="file"
                                            class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                                            id="file_input" type="file">
                                        @error('file')
                                            <p id="filled_error_help" class="mt-2 text-xs text-red-600 dark:text-red-400">
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    </div>
                                </div>
                                <div
                                    class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                                    <button data-modal-hide='import-modal' type="submit"
                                        class="text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:outline-none focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-800">
                                        Save
                                    </button>
                                    <button data-modal-hide='import-modal' type="button"
                                        class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-purple-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                                        Cancel
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
        @else
            <div class="text-center">No Data Found</div>
        @endif
    </div>

    <x-create-sparepart-modal :suppliers="$suppliers" />
@endsection
