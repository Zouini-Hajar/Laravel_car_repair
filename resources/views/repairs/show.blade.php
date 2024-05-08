@extends('layout')

@php
    $headers = ['Name', 'Reference', 'Quantity', 'Price', 'Total'];
    if (!$spareparts->isEmpty()) {
        $columns = array_keys($spareparts->first()->toArray());
    }
    $total = $repair->price;
@endphp

@section('content')
    <x-show-header :title="$repair->description" :route="$repair->id . '/edit'" />
    <div class="grid grid-cols-2 gap-8">
        <x-card title="Mechanic">
            <x-info-card :user="$user" :person="$mechanic" />
            <hr class="mb-4">
            <p class="text-sm">
                <span class="font-semibold text-sky-500">
                    <i class="fa-solid fa-pencil"></i> Notes :
                </span>
                {{ $repair->mechanic_notes }}
            </p>
        </x-card>
        <x-card title="Summary" :status="$repair->status">
            <div class="px-4">
                <div class="flex items-baseline justify-between gap-3 mb-2">
                    <div class="text-sm">Repair Price</div>
                    <div class="flex-1 border-b border-gray-400 border-dashed"></div>
                    <div class="font-bold">{{ $repair->price }} DH</div>
                </div>
                @if (!$spareparts->isEmpty())
                    @foreach ($spareparts as $part)
                        @php
                            $total += $part->quantity * $part->price;
                        @endphp
                        <div class="flex items-baseline justify-between gap-3 mb-2">
                            <div class="text-sm">{{ $part->name }}</div>
                            <div class="flex-1 border-b border-gray-400 border-dashed"></div>
                            <div class="font-bold">{{ $part->quantity * $part->price }} DH</div>
                        </div>
                    @endforeach
                @endif
                <div class="flex items-baseline justify-between gap-3 mb-2 text-purple-700">
                    <div class="font-semibold">Total</div>
                    <div class="flex-1 border-b border-purple-700 border-dashed"></div>
                    <div class="font-bold">{{ $total }} DH</div>
                </div>
            </div>
        </x-card>
        <x-card title="Spare Parts" :showButton="true" class="col-span-2">
            <div class="relative overflow-x-auto">
                @if (!$spareparts->isEmpty())
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <tr>
                                <th class="w-24"></th>
                                @foreach ($headers as $header)
                                    <th scope="col" class="px-6 py-3">
                                        {{ $header }}
                                    </th>
                                @endforeach
                                <th scope="col" class="px-6 py-3 text-center"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($spareparts as $item)
                                <tr onclick="window.location='{{ '/spareparts' . '/' . $item->id }}'"
                                    class="cursor-pointer bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <td class="text-center">
                                        @if ($item['picture'])
                                            <img class="w-10 h-10 rounded-full object-cover m-auto"
                                                src="{{ $item['picture'] }}" alt="Profile">
                                        @else
                                            <div
                                                class="m-auto flex justify-center items-center relative w-10 h-10 overflow-hidden bg-gray-100 rounded-full dark:bg-gray-600">
                                                <i class="fa-solid fa-gear"></i>
                                            </div>
                                        @endif
                                    </td>
                                    @foreach ($columns as $col)
                                        @if ($col != 'id' && $col != 'picture')
                                            <td class="px-6 py-4">
                                                @if ($col != 'quantity')
                                                    {{ $item[$col] }}
                                                @else
                                                    <div class="relative flex items-center">
                                                        <button type="button" id="decrement-button"
                                                            data-input-counter-decrement="counter-input"
                                                            class="flex-shrink-0 bg-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:border-gray-600 hover:bg-gray-200 inline-flex items-center justify-center border border-gray-300 rounded-md h-5 w-5 focus:ring-gray-100 dark:focus:ring-gray-700 focus:ring-2 focus:outline-none">
                                                            <i class="fa-solid fa-minus"></i>
                                                        </button>
                                                        <input type="text" id="counter-input" data-input-counter
                                                            class="flex-shrink-0 text-gray-900 dark:text-white border-0 bg-transparent text-sm font-normal focus:outline-none focus:ring-0 max-w-[2.5rem] text-center"
                                                            placeholder="" value="12" required />
                                                        <button type="button" id="increment-button"
                                                            data-input-counter-increment="counter-input"
                                                            class="flex-shrink-0 bg-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:border-gray-600 hover:bg-gray-200 inline-flex items-center justify-center border border-gray-300 rounded-md h-5 w-5 focus:ring-gray-100 dark:focus:ring-gray-700 focus:ring-2 focus:outline-none">
                                                            <i class="fa-solid fa-plus"></i>
                                                        </button>
                                                    </div>
                                                @endif
                                            </td>
                                        @endif
                                    @endforeach
                                    <td class="font-semibold px-6 py-4">
                                        {{ $item->quantity * $item->price }}
                                    </td>
                                    <td class="flex justify-center items-center px-6 py-4">
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
                @else
                    <div class="text-center">No Spare Parts were used</div>
                @endif
            </div>
        </x-card>
    </div>
@endsection
