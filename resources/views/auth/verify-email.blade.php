@extends('auth')

@section('content')
    <div class="flex gap-2 justify-center items-center h-screen">
        <div
            class="flex flex-col items-center justify-center w-4/5 md:w-1/2 lg:w-2/5 bg-white rounded-lg shadow mx-auto my-4 align-middle justify-center px-8 py-10">
            <div class="flex-1 p-5 self-center">
                <img src="{{ asset('assets/email-verify.svg') }}" class="mx-auto" alt="">
            </div>
            <h1 class="text-xl font-bold">Check your inbox, please!</h1>
            <p class="text-center my-4">We need to verify your email. We've already sent out the verification link. Please
                check it, and confirm it's
                really you.</p>
            <form method="POST" action="/email/verification-notification">
                @csrf
                <button type="submit"
                    class="text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:outline-none focus:ring-purple-300 font-medium rounded-lg text-sm w-full px-5 py-2.5 text-center dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-800">
                    Resend Link
                </button>
            </form>
        </div>
    </div>
@endsection
