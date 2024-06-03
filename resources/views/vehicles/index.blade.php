@extends('layout')

@php
    $headers = ['Make', 'Model', 'Year', 'License Plate', 'VIN', 'Fuel Type'];
    $columns = [];
    if (!$vehicles->isEmpty()) {
        $columns = array_keys($vehicles->first()->toArray());
    }
@endphp

@section('content')
    <x-table route="vehicles" title="Vehicles" :headers="$headers" :columns="$columns" :list="$vehicles" />
@endsection
