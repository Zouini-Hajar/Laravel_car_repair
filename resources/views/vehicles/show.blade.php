@extends('layout')

@php
    $headers = ['Description', 'Price', 'Status'];
    if (!$repairs->isEmpty()) {
        $columns = array_keys($repairs->first()->toArray());
    }
@endphp

@section('content')
    <x-show-header :title="$vehicle->make . ' ' . $vehicle->model" :route="$vehicle->id . '/edit'" />
    <div class="grid grid-cols-5 gap-8">
        <div
            class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700 col-span-3">
            <div class="flex justify-between items-center">
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white">
                    Repairs
                </h3>
                <button type="button" data-modal-target="create-modal" data-modal-show="create-modal"
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
                                    <td class="flex justify-center items-center px-6 py-4">
                                        <button type="button" onclick="event.stopPropagation();" data-modal-target="delete-modal"
                                            data-modal-toggle="delete-modal"
                                            class="text-red-700 border border-red-700 hover:bg-red-700 hover:text-white focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-full text-sm p-2.5 text-center inline-flex items-center dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:focus:ring-red-800 dark:hover:bg-red-500">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                <x-delete-modal :id="$repair->id" route="/repairs" />
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="text-center">No Repair Found</div>
                @endif
            </div>
        </div>
        <x-card title="Cover" class="col-span-2">
            <img class="h-auto w-full rounded-lg" src="{{ asset('assets/car.webp') }}" alt="Vehicle" />
        </x-card>
        <x-create-repair-modal :repairs="$repairs_details" :mechanics="$mechanics" :vehicle="$vehicle->id" />
    </div>
@endsection
