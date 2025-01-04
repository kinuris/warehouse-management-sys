@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="h-full w-full">
    <img src="{{ asset('assets/login_bg.jpg') }}" style="z-index: -1; position: fixed; left: 0; top: 0; width: 100%; height: 100vh; opacity: 0.4; object-fit: cover;" alt="Background">
    <div class="flex h-full place-items-center justify-center">
        <div class="w-96">
            <div class="card">
                <div class="card-header text-3xl mb-5 font-bold">{{ __('Login') }}</div>

                <div class="bg-gray-500/80 p-12 shadow-lg rounded-lg">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="row mb-3">
                            <label for="email" class="text-white">{{ __('Admin/User Email') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="w-full p-1 rounded @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="text-white">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="w-full p-1 rounded @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="text-white" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
