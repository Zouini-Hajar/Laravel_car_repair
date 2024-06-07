@extends('layout')

@php
    $headers = ['Description', 'Price', 'Status'];
    if (!$repairs->isEmpty()) {
        $columns = array_keys($repairs->first()->toArray());
    }
    $showButton = auth()->user()->role != 'mechanic';
@endphp

@section('content')
    <x-show-header :title="$vehicle->make . ' ' . $vehicle->model" :route="$vehicle->id . '/edit'" :showButton="$showButton" />
    <div class="grid grid-cols-5 gap-8">
        <div
            class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700 col-span-3">
            <div class="flex justify-between items-center">
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white">
                    Repairs
                </h3>
                <button type="button"
                    data-modal-target={{ auth()->user()->role == 'client' ? 'request-modal' : 'create-modal' }}
                    data-modal-show={{ auth()->user()->role == 'client' ? 'request-modal' : 'create-modal' }}
                    class="w-10 h-10 flex justify-center items-center text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:outline-none focus:ring-purple-300 font-medium rounded-full text-sm p-2.5 dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-800">
                    <i class="fa-solid fa-plus"></i>
                </button>
            </div>
            <hr class="my-4">
            <div class="relative overflow-x-auto sm:rounded-lg">
                @if (!$repairs->isEmpty())
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <tr>
                                @foreach ($headers as $header)
                                    <th scope="col" class="px-6 py-3">
                                        {{ $header }}
                                    </th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($repairs as $repair)
                                <tr onclick="window.location='{{ '/repairs' . '/' . $repair->id }}'"
                                    class="cursor-pointer bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    @foreach ($columns as $col)
                                        @if ($col != 'id')
                                            <td class="px-6 py-4">
                                                @if ($col != 'status')
                                                    {{ $repair[$col] }}
                                                @else
                                                    <x-status :status="$repair[$col]" />
                                                @endif
                                            </td>
                                        @endif
                                    @endforeach
                                    @if (auth()->user()->role != 'client')
                                        <td class="flex justify-center items-center px-6 py-4">
                                            <button type="button" onclick="event.stopPropagation();"
                                                data-modal-target="delete-modal" data-modal-toggle="delete-modal"
                                                class="text-red-700 border border-red-700 hover:bg-red-700 hover:text-white focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-full text-sm p-2.5 text-center inline-flex items-center dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:focus:ring-red-800 dark:hover:bg-red-500">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </td>
                                    @endif
                                </tr>
                                @if (auth()->user()->role != 'client')
                                    <x-delete-modal :id="$repair->id" route="/repairs" />
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="text-center">No Repair Found</div>
                @endif
            </div>
        </div>
        <x-card title="Cover" class="col-span-2">
            @if (!$vehicle['picture'])
                <img class="h-auto w-full rounded-lg" src="{{ asset('assets/car.png') }}" alt="Vehicle" />
            @else
                <img class="h-auto w-full rounded-lg" src="{{ asset('storage/' . $vehicle['picture']) }}" alt="Vehicle" />
            @endif
            <div class="flex justify-end mt-4">
                <button type="button" data-modal-target="image-modal" data-modal-show="image-modal"
                    class="w-full text-purple-700 hover:text-white border border-purple-700 hover:bg-purple-800 focus:ring-4 focus:outline-none focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 dark:border-purple-400 dark:text-purple-400 dark:hover:text-white dark:hover:bg-purple-500 dark:focus:ring-purple-900">
                    Add Image
                </button>
            </div>
        </x-card>
        @if (auth()->user()->role == 'client')
            <x-request-repair-modal :vehicle="$vehicle" />
        @else
            <x-create-repair-modal :repairs="$repairs_details" :mechanics="$mechanics" :vehicle="$vehicle->id" />
        @endif
    </div>
    <div id='image-modal' tabindex="-1" aria-hidden="true" data-modal-backdrop="static"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-2/5 max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Select Image
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-hide='image-modal'>
                        <i class="fa-solid fa-x"></i>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <form method="POST" action="/vehicles/{{ $vehicle->id }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="p-4 md:p-5 space-y-4">
                        <div class="mb-5">
                            <label for="file" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Choose file
                            </label>
                            <input name="picture"
                                class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                                id="file_input" type="file">
                            @error('file')
                                <p id="filled_error_help" class="mt-2 text-xs text-red-600 dark:text-red-400">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                    <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                        <button data-modal-hide='image-modal' type="submit"
                            class="text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:outline-none focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-800">
                            Save
                        </button>
                        <button data-modal-hide='image-modal' type="button"
                            class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-purple-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
