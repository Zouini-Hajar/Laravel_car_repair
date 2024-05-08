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
        <x-card title="Repairs" :showButton="true" class="col-span-3">
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
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="text-center">No Repair Found</div>
                @endif
            </div>
        </x-card>
        <x-card title="Cover" class="col-span-2">
            <img class="h-auto w-full rounded-lg" src="{{ asset('assets/car.webp') }}" alt="Vehicle" />
        </x-card>
    </div>
@endsection
