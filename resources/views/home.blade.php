@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <div class="container mx-auto px-4 py-6 max-w-7xl">
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Sacred Places</h1>
            <a
                href="{{ route('sacredplaces.create') }}"
                class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600"
            >
                Add New Sacred Place
            </a>
        </div>

        @livewire('sacred-places-list')
        </div>
@endsection

