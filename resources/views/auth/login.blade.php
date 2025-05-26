@extends('frontend.layouts.app', ['title' => 'Login'])

@section('content')
<section class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="  space-y-8" style="width: 350px;">
        <div class="text-center">
            <h2 class="mt-6 text-3xl font-extrabold text-gray-900">
                Welcome back
            </h2>
            <p class="mt-2 text-sm text-gray-600">
                Sign in to your account
            </p>
        </div>

        <!-- Session Status -->
        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <form class="mt-8 space-y-6" method="POST" action="{{ route('login') }}">
            @csrf
            <div class="rounded-md shadow-sm space-y-4">
                <!-- Email Input -->
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email address</label>
                    <input
                        id="email"
                        name="email"
                        type="email"
                        autocomplete="email"
                        required
                        value="{{ old('email') }}"
                        class="appearance-none relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm"
                        placeholder="your@email.com"
                    >
                    @error('email')
                        <p class="mt-1 text-sm text-red-600" style="color: rgb(235, 38, 38)">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password Input -->
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input
                        id="password"
                        name="password"
                        type="password"
                        autocomplete="current-password"
                        required
                        class="appearance-none relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm"
                        placeholder="••••••••"
                    >
                    @error('password')
                        <p class="mt-1 text-sm text-red-600" style="color: rgb(235, 38, 38)">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex items-center justify-between">
                <!-- Remember Me -->
                <div class="flex items-center">
                    <input
                        id="remember_me"
                        name="remember"
                        type="checkbox"
                        class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                    >
                    <label for="remember_me" class="ml-2 block text-sm text-gray-700">
                        Remember me
                    </label>
                </div>

                <!-- Forgot Password -->
                @if (Route::has('password.request'))
                    <div class="text-sm">
                        <a href="{{ route('password.request') }}" class="font-medium text-blue-600 hover:text-blue-500">
                            Forgot your password?
                        </a>
                    </div>
                @endif
            </div>

            <!-- Submit Button -->
            <div>
                <button type="submit" class="w-full mt-4 rounded-md text-white font-medium py-2.5 px-5.5 bg-dark hover:opacity-90 lg:transition-all lg:ease-linear lg:duration-200">
                    Sign in
                </button>
            </div>
        </form>

        <!-- Registration Link -->
        @if (Route::has('register'))
            <div class="text-center text-sm text-gray-600">
                <p>Don't have an account? <a href="{{ route('register') }}" class="font-medium text-blue-600 hover:text-blue-500">Register here</a></p>
            </div>
        @endif
    </div>
</section>
@endsection
