@extends('layout')

@section('content')
    <x-show-header :title="$vehicle->make . ' ' . $vehicle->model" />
    <div class="grid grid-cols-5 gap-8">
        <x-card title="Repairs" class="col-span-3"></x-card>
        <x-card title="Cover" class="col-span-2">
            <img class="h-auto w-full rounded-lg" src="{{ asset('assets/car.webp') }}" alt="Vehicle" />
        </x-card>
    </div>
@endsection
