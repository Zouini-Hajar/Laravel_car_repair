@extends('auth')

@section('content')
    <div class="w-4/5 md:w-1/2 lg:w-2/5 bg-white rounded-lg shadow mx-auto my-4 flex flex-col align-middle justify-center p-8">
        <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 mb-5">
            Create an account
        </h1>
        <form method="POST" action="/register" class="w-full flex-1">
            @csrf
            <div class="flex gap-5 mb-5">
                <div class="flex-1">
                    <label for="first_name" class="block mb-2 text-sm font-medium text-gray-900">
                        First Name
                    </label>
                    <input type="text" id="first_name" name="first_name" value="{{ old('first_name') }}"
                        placeholder="First Name"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-purple-500 focus:border-purple-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-purple-500 dark:focus:border-purple-500" />
                    @error('first_name')
                        <p id="filled_error_help" class="mt-2 text-xs text-red-600 dark:text-red-400">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
                <div class="flex-1">
                    <label for="last_name" class="block mb-2 text-sm font-medium text-gray-900">
                        Last Name
                    </label>
                    <input type="text" id="last_name" name="last_name" value="{{ old('last_name') }}"
                        placeholder="Last Name"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-purple-500 focus:border-purple-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-purple-500 dark:focus:border-purple-500" />
                    @error('last_name')
                        <p id="filled_error_help" class="mt-2 text-xs text-red-600 dark:text-red-400">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>
            <div class="mb-5">
                <label for="address" class="block mb-2 text-sm font-medium text-gray-900">
                    Address
                </label>
                <input type="text" id="address" name="address" value="{{ old('address') }}" placeholder="Adress"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-purple-500 focus:border-purple-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-purple-500 dark:focus:border-purple-500" />
                @error('address')
                    <p id="filled_error_help" class="mt-2 text-xs text-red-600 dark:text-red-400">
                        {{ $message }}
                    </p>
                @enderror
            </div>
            <div class="mb-5">
                <label for="email" class="block mb-2 text-sm font-medium text-gray-900">
                    Email
                </label>
                <input type="email" id="email" name="email" value="{{ old('email') }}"
                    placeholder="example@example.com"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-purple-500 focus:border-purple-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-purple-500 dark:focus:border-purple-500" />
                @error('email')
                    <p id="filled_error_help" class="mt-2 text-xs text-red-600 dark:text-red-400">
                        {{ $message }}
                    </p>
                @enderror
            </div>
            <div class="flex gap-5">
                <div class="mb-5 flex-1">
                    <label for="phone_number" class="block mb-2 text-sm font-medium text-gray-900">
                        Phone Number
                    </label>
                    <input type="text" id="phone_number" name="phone_number" value="{{ old('phone_number') }}"
                        placeholder="Phone Number" regex="/^(?:\+212|0)([5-7]\d{8})$/"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-purple-500 focus:border-purple-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-purple-500 dark:focus:border-purple-500" />
                    @error('phone_number')
                        <p id="filled_error_help" class="mt-2 text-xs text-red-600 dark:text-red-400">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
                <div class="mb-5 flex-1">
                    <label for="cin" class="block mb-2 text-sm font-medium text-gray-900">
                        CIN
                    </label>
                    <input type="text" id="cin" name="cin" value="{{ old('cin') }}" placeholder="CIN"
                        regex="/^[A-Za-z]\d{6}$/"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-purple-500 focus:border-purple-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-purple-500 dark:focus:border-purple-500" />
                    @error('cin')
                        <p id="filled_error_help" class="mt-2 text-xs text-red-600 dark:text-red-400">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>
            <div class="mb-5">
                <label for="password" class="block mb-2 text-sm font-medium text-gray-900">Password</label>
                <input type="password" name="password" id="password" placeholder="••••••••"
                    class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-purple-600 focus:border-purple-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    required="">
            </div>
            <div class="mb-5">
                <label for="password_confirmation" class="block mb-2 text-sm font-medium text-gray-900">Confirm
                    password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" placeholder="••••••••"
                    class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-purple-600 focus:border-purple-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    required="">
            </div>
            <button type="submit"
                class="text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:outline-none focus:ring-purple-300 font-medium rounded-lg text-sm w-full px-5 py-2.5 text-center dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-800">
                Register
            </button>
            <p class="text-sm mt-2 font-light text-gray-500 dark:text-gray-400">
                Already have an account? <a href="/login"
                    class="font-medium text-purple-600 hover:underline dark:text-purple-500">Login here</a>
            </p>
        </form>
    </div>
@endsection
