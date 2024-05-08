@extends('layout')

@section('content')
    <x-show-header title="Edit Mechanic" :showButton="false" />
    <div class="flex">
        <form method="POST" action="/mechanics/{{$mechanic->id}}" enctype="multipart/form-data" class="max-w-md p-5 flex-1">
            @csrf
            @method('PUT')
            <div class="relative z-0 w-full mb-5 group">
                <img class="h-28 w-28 object-cover rounded-full shadow-l dark:shadow-gray-400"
                    src="{{ asset('storage/' . $user->picture) }}" alt="Profile">
            </div>
            <div class="mb-5">
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="user_avatar">
                    Profile Picture
                </label>
                <input
                    class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                    aria-describedby="user_avatar_help" id="user_avatar" name="picture" type="file">
                @error('picture')
                    <p id="filled_error_help" class="mt-2 text-xs text-red-600 dark:text-red-400">
                        {{ $message }}
                    </p>
                @enderror
            </div>
            <div class="flex gap-5">
                <div class="mb-5 flex-1">
                    <label for="first_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        First Name
                    </label>
                    <input type="text" id="first_name" name="first_name" value="{{ $mechanic->first_name }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-purple-500 focus:border-purple-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-purple-500 dark:focus:border-purple-500" />
                    @error('first_name')
                        <p id="filled_error_help" class="mt-2 text-xs text-red-600 dark:text-red-400">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
                <div class="mb-5 flex-1">
                    <label for="last_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        Last Name
                    </label>
                    <input type="text" id="last_name" name="last_name" value="{{ $mechanic->last_name }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-purple-500 focus:border-purple-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-purple-500 dark:focus:border-purple-500" />
                    @error('last_name')
                        <p id="filled_error_help" class="mt-2 text-xs text-red-600 dark:text-red-400">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>
            <div class="mb-5">
                <label for="address" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                    Address
                </label>
                <input type="text" id="address" name="address" value="{{ $mechanic->address }}"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-purple-500 focus:border-purple-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-purple-500 dark:focus:border-purple-500" />
                @error('address')
                    <p id="filled_error_help" class="mt-2 text-xs text-red-600 dark:text-red-400">
                        {{ $message }}
                    </p>
                @enderror
            </div>
            <div class="mb-5">
                <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                    Email
                </label>
                <input type="email" id="email" name="email" value="{{ $user->email }}"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-purple-500 focus:border-purple-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-purple-500 dark:focus:border-purple-500" />
                @error('email')
                    <p id="filled_error_help" class="mt-2 text-xs text-red-600 dark:text-red-400">
                        {{ $message }}
                    </p>
                @enderror
            </div>
            <div class="flex gap-5">
                <div class="mb-5 flex-1">
                    <label for="phone_number" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        Phone Number
                    </label>
                    <input type="text" id="phone_number" name="phone_number" regex="/^(?:\+212|0)([5-7]\d{8})$/" value="{{ $mechanic->phone_number }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-purple-500 focus:border-purple-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-purple-500 dark:focus:border-purple-500" />
                    @error('phone_number')
                        <p id="filled_error_help" class="mt-2 text-xs text-red-600 dark:text-red-400">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
                <div class="mb-5 flex-1">
                    <label for="cin" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        CIN
                    </label>
                    <input type="text" id="cin" name="cin" regex="/^[A-Za-z]\d{6}$/" value="{{ $mechanic->cin }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-purple-500 focus:border-purple-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-purple-500 dark:focus:border-purple-500" />
                    @error('cin')
                        <p id="filled_error_help" class="mt-2 text-xs text-red-600 dark:text-red-400">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>
            <div class="mb-5">
                <label for="recruitment_date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                    Recruitment Date
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                        </svg>
                    </div>
                    <input datepicker type="text" id="recruitment_date" name="recruitment_date" value="{{ $mechanic->recruitment_date }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-purple-500 focus:border-purple-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-purple-500 dark:focus:border-purple-500"
                        placeholder="Select date">
                </div>
                @error('recruitment_date')
                    <p id="filled_error_help" class="mt-2 text-xs text-red-600 dark:text-red-400">
                        {{ $message }}
                    </p>
                @enderror
            </div>
            <div class="mb-5">
                <label for="salary" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                    Salary
                </label>
                <input type="number" id="salary" name="salary" value="{{ $mechanic->salary }}"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-purple-500 focus:border-purple-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-purple-500 dark:focus:border-purple-500" />
                @error('salary')
                    <p id="filled_error_help" class="mt-2 text-xs text-red-600 dark:text-red-400">
                        {{ $message }}
                    </p>
                @enderror
            </div>
            <button type="submit"
                class="text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:outline-none focus:ring-purple-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-800">
                Save
            </button>
        </form>
        <div class="flex-1 p-5">
            <img src="{{ asset('assets/add_mechanic.svg') }}" class="mx-auto" alt="">
        </div>
    </div>
@endsection
