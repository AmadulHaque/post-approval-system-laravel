@extends('frontend.layouts.app', ['title' => 'Register'])

@section('content')
<section class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="  space-y-8" style="width: 350px;">
        <div class="text-center">
            <h2 class="mt-6 text-3xl font-extrabold text-gray-900">
                Create your account
            </h2>
            <p class="mt-2 text-sm text-gray-600">
                Join our community today
            </p>
        </div>

        <!-- Session Status -->
        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif


        <form class="mt-8 space-y-6" method="POST" action="{{ route('register') }}">
            @csrf
            <div class="rounded-md shadow-sm space-y-4">
                <!-- Name Input -->
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                    <input
                        id="name"
                        name="name"
                        type="text"
                        autocomplete="name"
                        required
                        value="{{ old('name') }}"
                        class="appearance-none relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm"
                        placeholder="John Doe"
                    >
                    @error('name')
                        <p class="mt-1 text-sm text-red-600" style="color: rgb(235, 38, 38)">{{ $message }}</p>
                    @enderror
                </div>

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
                        autocomplete="new-password"
                        required
                        class="appearance-none relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm"
                        placeholder="••••••••"
                    >
                    @error('password')
                        <p class="mt-1 text-sm text-red-600" style="color: rgb(235, 38, 38)">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password Input -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                    <input
                        id="password_confirmation"
                        name="password_confirmation"
                        type="password"
                        autocomplete="new-password"
                        required
                        class="appearance-none relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm"
                        placeholder="••••••••"
                    >
                    @error('password_confirmation')
                        <p class="mt-1 text-sm text-red-600" style="color: rgb(235, 38, 38)">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex items-center justify-between">
                <!-- Login Link -->
                <div class="text-sm">
                    <a href="{{ route('login') }}" class="font-medium text-blue-600 hover:text-blue-500">
                        Already registered?
                    </a>
                </div>
            </div>

            <!-- Submit Button -->
            <div>
                <button type="submit" class="w-full mt-4 rounded-md text-white font-medium py-2.5 px-5.5 bg-dark hover:opacity-90 lg:transition-all lg:ease-linear lg:duration-200">
                    Register
                </button>
            </div>
        </form>

    </div>
</section>
@endsection
