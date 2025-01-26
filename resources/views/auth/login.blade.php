@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="h-full w-full">
    <img src="{{ asset('assets/login_bg.jpg') }}" style="z-index: -1; position: fixed; left: 0; top: 0; width: 100%; height: 100vh; opacity: 0.4; object-fit: cover;" alt="Background">
    <div class="flex h-screen items-center justify-center">
        <div class="w-full max-w-md px-6">
            <div class="text-center mb-8">
                <h1 class="text-4xl font-bold text-gray-800">{{ __('Welcome Back') }}</h1>
                <p class="text-gray-600 mt-2">{{ __('Please login to your account') }}</p>
            </div>

            <div class="bg-white/95 p-8 shadow-2xl rounded-lg backdrop-blur-sm">
                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf
                    <div class="space-y-2">
                        <label for="email" class="block text-sm font-medium text-gray-700">{{ __('Email Address') }}</label>
                        <input id="email" type="email" 
                            class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('email') border-red-500 @enderror" 
                            name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-2">
                        <label for="password" class="block text-sm font-medium text-gray-700">{{ __('Password') }}</label>
                        <input id="password" type="password" 
                            class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('password') border-red-500 @enderror" 
                            name="password" required autocomplete="current-password">
                        @error('password')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input type="checkbox" name="remember" id="remember" 
                                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                                {{ old('remember') ? 'checked' : '' }}>
                            <label for="remember" class="ml-2 block text-sm text-gray-700">
                                {{ __('Remember Me') }}
                            </label>
                        </div>
                        @if (Route::has('password.request'))
                            <a class="text-sm text-blue-600 hover:text-blue-800" href="{{ route('password.request') }}">
                                {{ __('Forgot Password?') }}
                            </a>
                        @endif
                    </div>

                    <button type="submit" 
                        class="w-full py-3 px-4 border border-transparent rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 text-sm font-medium transition duration-150 ease-in-out">
                        {{ __('Sign In') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
