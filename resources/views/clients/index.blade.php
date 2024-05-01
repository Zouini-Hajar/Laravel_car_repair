@extends('layout')

@php
    $headers = ['First Name', 'Last Name', 'CIN', 'Phone Number'];
    $columns = array_keys($clients->first()->toArray());
@endphp

@section('content')
    <x-table route="clients" title="Clients" :headers="$headers" :columns="$columns" :list="$clients" />
@endsection
