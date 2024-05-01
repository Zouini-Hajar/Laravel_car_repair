@extends('layout')

@php
    $headers = ['First Name', 'Last Name', 'CIN', 'Phone Number'];
    $columns = array_keys($mechanics->first()->toArray());
@endphp

@section('content')
    <x-table route="mechanics" title="Mechanics" :headers="$headers" :columns="$columns" :list="$mechanics" />
@endsection
