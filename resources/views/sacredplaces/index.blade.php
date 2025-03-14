@extends('layouts.app')

@section('content')
    <div class="bg-white">
        <div class="container mx-auto px-4 py-8">
            <div class="max-w-7xl mx-auto">
                <!-- Search Header -->
                <div class="mb-8">
                    <h1 class="text-3xl font-bold mb-2">Search Results</h1>
                    <p class="text-gray-600">Showing places for: <span class="font-medium">{{ $search }}</span></p>
                </div>

                <!-- Results Grid using Livewire component -->
                <div>
                    @livewire('sacred-places-list', ['search' => $search])
                </div>
            </div>
            </div>
            </div>

    <style>
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }

        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
@endsection