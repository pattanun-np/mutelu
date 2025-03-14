@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-md mx-auto bg-white rounded-lg shadow-sm p-6">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Login</h1>

            @if (session('error'))
                <div
                    class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow"
                    role="alert"
                >
                    <p>{{ session('error') }}</p>
                </div>
            @endif

            <form
                method="POST"
                action="{{ route('login') }}"
            >
                @csrf

                <div class="mb-4">
                    <label
                        for="email"
                        class="block text-sm font-medium text-gray-700 mb-1"
                    >Email Address</label>
                    <input
                        type="email"
                        name="email"
                        id="email"
                        value="{{ old('email') }}"
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-rose-500 focus:ring focus:ring-rose-200 focus:ring-opacity-50 @error('email') border-red-500 @enderror"
                        required
                        autocomplete="email"
                        autofocus
                    >
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label
                        for="password"
                        class="block text-sm font-medium text-gray-700 mb-1"
                    >Password</label>
                    <input
                        type="password"
                        name="password"
                        id="password"
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-rose-500 focus:ring focus:ring-rose-200 focus:ring-opacity-50 @error('password') border-red-500 @enderror"
                        required
                        autocomplete="current-password"
                    >
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center">
                        <input
                            type="checkbox"
                            name="remember"
                            id="remember"
                            class="rounded border-gray-300 text-rose-600 shadow-sm focus:border-rose-300 focus:ring focus:ring-rose-200 focus:ring-opacity-50"
                            {{ old('remember') ? 'checked' : '' }}
                        >
                        <label
                            for="remember"
                            class="ml-2 text-sm text-gray-600"
                        >Remember Me</label>
                    </div>
                </div>

                <div class="flex flex-col space-y-4">
                    <button
                        type="submit"
                        class="w-full bg-rose-600 hover:bg-rose-700 text-white font-medium py-2 px-4 rounded-lg shadow-sm transition-colors"
                    >
                        Login
                    </button>

                    <div class="text-center text-sm text-gray-600">
                        Don't have an account?
                        <a
                            href="{{ route('register') }}"
                            class="text-rose-600 hover:text-rose-800 font-medium"
                        >
                            Register
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection