@extends('auth')

@php
    extract($data);
@endphp

@section('content')
    <div class="flex justify-center items-center h-screen">
        <div class="flex w-3/5 bg-white rounded-lg shadow mx-auto my-4 align-middle justify-center px-8 py-14">
            <div class="flex-1 flex flex-col">
                <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 mb-5">
                    Select mechanic
                </h1>
                <form method="POST" action="/meetings" class="w-full flex-1">
                    @csrf
                    <div class="mb-5">
                        <label for="mechanic_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Mechanic
                        </label>
                        <select id="mechanic_id" name="mechanic_id"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-purple-500 focus:border-purple-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-purple-500 dark:focus:border-purple-500">
                            <option value="">Select Mechanic</option>
                            @foreach ($mechanics as $mechanic)
                                <option value="{{ $mechanic->id }}" @selected($mechanic->id == old('mechanic_id'))>
                                    {{ $mechanic->first_name . ' ' . $mechanic->last_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('mechanic_id')
                            <p id="filled_error_help" class="mt-2 text-xs text-red-600 dark:text-red-400">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                    <input class="hidden" type="text" name="vehicle_id" value={{ $vehicle_id }} />
                    <input class="hidden" type="text" name="client_id" value={{ $client_id }} />
                    <input class="hidden" type="text" name="date" value={{ $date }} />
                    <input class="hidden" type="time" name="time" value={{ $time }} />
                    <button type="submit"
                        class="text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:outline-none focus:ring-purple-300 font-medium rounded-lg text-sm w-full px-5 py-2.5 text-center dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-800">
                        Save
                    </button>
                </form>
            </div>
            <div class="flex-1 p-5 self-center hidden lg:block">
                <img src="{{ asset('assets/add_mechanic.svg') }}" class="w-4/5 mx-auto" alt="">
            </div>
        </div>
    </div>
@endsection
