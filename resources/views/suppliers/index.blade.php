@extends('layout')

@php
    $headers = ['Name', 'Email', 'Phone Number', 'Address'];
    $columns = array_keys($suppliers->first()->toArray());
@endphp

@section('content')
    <x-table route="suppliers" title="Suppliers" :headers="$headers" :columns="$columns" :list="$suppliers" />
@endsection
