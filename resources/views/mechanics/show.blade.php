@extends('layout')

@php
    $headers = ['Repair', 'Vehicle', 'Notes', 'Status'];
    if (!$repairs->isEmpty()) {
        $columns = array_keys($repairs->first()->toArray());
    }
@endphp

@section('content')
    <x-show-header :title="$mechanic->first_name . ' ' . $mechanic->last_name" :route="$mechanic->id . '/edit'" />
    <div class="grid grid-cols-5 gap-8">
        <x-card title="Info" class="col-span-3">
            <x-info-card :user="$user" :person="$mechanic" />
        </x-card>
        <x-card title="Recruitment" class="col-span-2">
            <div class="px-4">
                <div class="flex items-baseline justify-between gap-3 mb-2">
                    <div class="text-sm"><i class="fa-solid fa-briefcase me-1"></i> Recruitment Date :</div>
                    <div class="flex-1 border-b border-gray-400 border-dashed"></div>
                    <div class="font-semibold">{{ $mechanic->recruitment_date }}</div>
                </div>
                <div class="flex items-baseline justify-between gap-3 mb-2">
                    <div class="text-sm"><i class="fa-solid fa-money-bill"></i> Salary :</div>
                    <div class="flex-1 border-b border-gray-400 border-dashed"></div>
                    <div class="font-semibold">{{ $mechanic->salary }} DH</div>
                </div>
            </div>
        </x-card>
        <x-card title="Tasks" class="col-span-5">
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
                    <div class="text-center">No Tasks Found</div>
                @endif
            </div>
        </x-card>
    </div>
@endsection
