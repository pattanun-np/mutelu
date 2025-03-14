@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-md mx-auto bg-white rounded-lg shadow-sm p-6">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Register</h1>

            <form
                method="POST"
                action="{{ route('register') }}"
            >
                @csrf

                <div class="mb-4">
                    <label
                        for="name"
                        class="block text-sm font-medium text-gray-700 mb-1"
                    >Name</label>
                    <input
                        type="text"
                        name="name"
                        id="name"
                        value="{{ old('name') }}"
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-rose-500 focus:ring focus:ring-rose-200 focus:ring-opacity-50 @error('name') border-red-500 @enderror"
                        required
                        autocomplete="name"
                        autofocus
                    >
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

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
                    >
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
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
                        autocomplete="new-password"
                    >
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label
                        for="password-confirm"
                        class="block text-sm font-medium text-gray-700 mb-1"
                    >Confirm Password</label>
                    <input
                        type="password"
                        name="password_confirmation"
                        id="password-confirm"
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-rose-500 focus:ring focus:ring-rose-200 focus:ring-opacity-50"
                        required
                        autocomplete="new-password"
                    >
                </div>

                <div class="flex flex-col space-y-4">
                    <button
                        type="submit"
                        class="w-full bg-rose-600 hover:bg-rose-700 text-white font-medium py-2 px-4 rounded-lg shadow-sm transition-colors"
                    >
                        Register
                    </button>

                    <div class="text-center text-sm text-gray-600">
                        Already have an account?
                        <a
                            href="{{ route('login') }}"
                            class="text-rose-600 hover:text-rose-800 font-medium"
                        >
                            Login
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection