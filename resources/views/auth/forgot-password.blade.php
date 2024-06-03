@extends('auth')

@section('content')
    <div class="flex gap-2 justify-center items-center h-screen">
        <div
            class="flex flex-col items-center justify-center w-4/5 md:w-1/2 lg:w-2/5 bg-white rounded-lg shadow mx-auto my-4 align-middle px-8 py-10">
            <div class="flex-1 p-5 self-center">
                <img src="{{ asset('assets/reset-pwd.svg') }}" class="mx-auto" alt="">
            </div>
            <h1 class="text-xl font-bold">Forgot Password</h1>
            <p class="text-center">
                Enter your email and we'll send you a link to reset a password
            </p>
            <form class="w-full flex flex-col items-center gap-3 mt-4" method="POST" action="/forgot-password">
                @csrf
                <input type="email" id="email" name="email" value="{{ old('email') }}"
                    placeholder="Enter your email"
                    class="w-4/5 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-purple-500 focus:border-purple-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-purple-500 dark:focus:border-purple-500" />
                @error('email')
                    <p id="filled_error_help" class="text-xs text-red-600 dark:text-red-400">
                        {{ $message }}
                    </p>
                @enderror
                <button type="submit"
                    class="text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:outline-none focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-800">
                    Reset Password
                </button>
            </form>
        </div>
    </div>
@endsection
