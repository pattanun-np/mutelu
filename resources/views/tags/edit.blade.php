@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="flex items-center mb-6">
            <a
                href="{{ route('tags.index') }}"
                class="text-rose-600 hover:text-rose-800 mr-4"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5"
                    viewBox="0 0 20 20"
                    fill="currentColor"
                >
                    <path
                        fill-rule="evenodd"
                        d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z"
                        clip-rule="evenodd"
                    />
                </svg>
            </a>
            <h1 class="text-3xl font-bold text-gray-800">Edit Tag: {{ $tag->name }}</h1>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-6">
            <form
                action="{{ route('tags.update', $tag) }}"
                method="POST"
            >
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label
                        for="name"
                        class="block text-sm font-medium text-gray-700 mb-1"
                    >Name</label>
                    <input
                        type="text"
                        name="name"
                        id="name"
                        value="{{ old('name', $tag->name) }}"
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-rose-500 focus:ring focus:ring-rose-200 focus:ring-opacity-50 @error('name') border-red-500 @enderror"
                        required
                    >
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label
                        for="description"
                        class="block text-sm font-medium text-gray-700 mb-1"
                    >Description</label>
                    <textarea
                        name="description"
                        id="description"
                        rows="4"
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-rose-500 focus:ring focus:ring-rose-200 focus:ring-opacity-50 @error('description') border-red-500 @enderror"
                    >{{ old('description', $tag->description) }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end">
                    <a
                        href="{{ route('tags.index') }}"
                        class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium py-2 px-4 rounded-lg shadow-sm transition-colors mr-2"
                    >
                        Cancel
                    </a>
                    <button
                        type="submit"
                        class="bg-rose-600 hover:bg-rose-700 text-white font-medium py-2 px-4 rounded-lg shadow-sm transition-colors"
                    >
                        Update Tag
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection