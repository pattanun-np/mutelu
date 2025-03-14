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
            <h1 class="text-3xl font-bold text-gray-800">Tag: {{ $tag->name }}</h1>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
            <div class="mb-4">
                <h2 class="text-xl font-semibold text-gray-800 mb-2">Description</h2>
                <p class="text-gray-600">{{ $tag->description ?: 'No description provided.' }}</p>
            </div>

            @if(session()->has('user_id'))
                <div class="flex justify-end">
                    <a
                        href="{{ route('tags.edit', $tag) }}"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-lg shadow-sm transition-colors mr-2"
                    >
                        Edit
                    </a>
                    <form
                        action="{{ route('tags.destroy', $tag) }}"
                        method="POST"
                        class="inline"
                        onsubmit="return confirm('Are you sure you want to delete this tag?');"
                    >
                        @csrf
                        @method('DELETE')
                        <button
                            type="submit"
                            class="bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-lg shadow-sm transition-colors"
                        >
                            Delete
                        </button>
                    </form>
                </div>
            @endif
        </div>

        <h2 class="text-2xl font-bold text-gray-800 mb-4">Sacred Places with this Tag</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($sacredplaces as $sacredplace)
                <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                    <div class="relative h-48">
                        @if ($sacredplace->image)
                            <img
                                src="{{ $sacredplace->image ? $sacredplace->image == "" : '/images/placeholder.png' }}"
                                alt="{{ $sacredplace->name }}"
                                class="w-full h-full object-cover"
                            >
                        @else
                            <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                                <span class="text-gray-400">No image</span>
                            </div>
                        @endif
                    </div>
                    <div class="p-4">
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">{{ $sacredplace->name }}</h3>
                        <p class="text-gray-600 text-sm mb-4">
                            {{ Str::limit($sacredplace->description, 100) }}</p>
                        <a
                            href="{{ route('sacredplaces.show', $sacredplace) }}"
                            class="text-rose-600 hover:text-rose-800 font-medium"
                        >
                            View Details
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-8 text-gray-500">
                    No sacred places found with this tag.
                </div>
            @endforelse
        </div>
    </div>
@endsection 