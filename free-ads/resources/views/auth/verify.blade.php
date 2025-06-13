@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white overflow-hidden shadow-md rounded-lg">
        <div class="px-6 py-4 bg-gray-50 border-b">
            <h2 class="font-bold text-xl text-gray-800">{{ __('Verify Your Email Address') }}</h2>
        </div>

        <div class="p-6">
            @if (session('resent'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ __('A fresh verification link has been sent to your email address.') }}
                </div>
            @endif

            <p class="text-gray-700 mb-4">
                {{ __('Before proceeding, please check your email for a verification link.') }}
                {{ __('If you did not receive the email') }}
            </p>
            
            <form class="inline" method="POST" action="{{ route('verification.resend') }}">
                @csrf
                <button type="submit" class="text-blue-500 hover:text-blue-700 text-sm font-medium">
                    {{ __('click here to request another') }}
                </button>.
            </form>
        </div>
    </div>
</div>
@endsection