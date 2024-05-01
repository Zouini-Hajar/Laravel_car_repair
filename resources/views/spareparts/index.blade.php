@extends('layout')

@php
    $headers = ['Name', 'Reference', 'Stock', 'Price'];
    $columns = array_keys($spareparts->first()->toArray());
@endphp

@section('content')
    <x-table route="spareparts" title="Spare Parts" :headers="$headers" :columns="$columns" :list="$spareparts" />
@endsection
