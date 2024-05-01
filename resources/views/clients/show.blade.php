@extends('layout')

@php
    $headers = ['#', 'Make', 'Model', 'License Plate', 'Status'];
    if (!$vehicles->isEmpty()) {
        $columns = array_keys($vehicles->first()->toArray());
    }
@endphp

@section('content')
    <x-show-header :title="$client->first_name . ' ' . $client->last_name" />
    <div class="grid grid-cols-2 gap-8">
        <x-card title="Info">
            <div class="flex items-center gap-6 my-6">
                @if ($user['picture'])
                    <img class="w-20 h-20 rounded-full object-cover" src="{{ $user['picture'] }}" alt="Profile">
                @else
                    <div
                        class="relative inline-flex items-center justify-center w-20 h-20 overflow-hidden bg-gray-100 rounded-full dark:bg-gray-600">
                        <span
                            class="font-medium text-gray-600 dark:text-gray-300">{{ $client['first_name'][0] . $client['last_name'][0] }}</span>
                    </div>
                @endif
                <ul class="basis-3/5 max-w-md space-y-1 text-gray-500 list-inside dark:text-gray-400">
                    <li class="flex items-center">
                        <i class="fa-solid fa-envelope mr-2"></i>
                        <span class="text-sm">{{ $user->email }}</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fa-solid fa-phone mr-2"></i>
                        <span class="text-sm">{{ $client->phone_number }}</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fa-solid fa-location-dot mr-2"></i>
                        <span class="text-sm">{{ $client->address }}</span>
                    </li>
                </ul>
            </div>
        </x-card>
        <x-card title="Invoices">
            <ul class="max-w-md space-y-1 text-gray-500 list-inside dark:text-gray-400">
                <li class="flex items-center justify-between">
                    <span>
                        <i class="fa-solid fa-circle-check text-green-500 mr-1"></i>
                        Brake System Repair
                    </span>
                    <span class="font-bold text-gray-900">500 DH</span>
                </li>
                <li class="flex items-center justify-between">
                    <span>
                        <i class="fa-solid fa-circle-check text-green-500 mr-1"></i>
                        Wheel Alignment
                    </span>
                    <span class="font-bold text-gray-900">300 DH</span>
                </li>
                <li class="flex items-center justify-between">
                    <span>
                        <i class="fa-solid fa-circle-check text-red-500 mr-1"></i>
                        Fuel System Tune Up
                    </span>
                    <span class="font-bold text-gray-900">700 DH</span>
                </li>
            </ul>
        </x-card>
        <x-card title="Vehicles" class="col-span-2">
            <div class="relative overflow-x-auto sm:rounded-lg">
                @if (!$vehicles->isEmpty())
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
                            @foreach ($vehicles as $vehicle)
                                <tr onclick="window.location='{{ '/vehicles' . '/' . $vehicle->id }}'"
                                    class="cursor-pointer bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    @foreach ($columns as $col)
                                        <td class="px-6 py-4">
                                            @if ($col != 'status')
                                                {{ $vehicle[$col] }}
                                            @else
                                                <x-status :status="$vehicle[$col]" />
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="text-center">No Vehicle Found</div>
                @endif

            </div>
        </x-card>
    </div>
@endsection
