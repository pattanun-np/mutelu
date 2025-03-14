@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <div class="bg-white">
        <!-- Hero Section -->
        <div class="relative bg-gradient-to-r from-rose-50 to-rose-100 py-16">
            <div class="container mx-auto px-4">
                <div class="max-w-3xl mx-auto text-center">
                    <h1 class="text-4xl md:text-5xl font-bold text-rose-500 mb-4">Discover Sacred Places
                    </h1>
                    <p class="text-xl text-gray-700 mb-8">Find spiritual destinations and connect with
                        sacred sites around the world</p>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="container mx-auto px-4 py-8">
            <!-- Sacred Places List -->
            <div>
                @livewire('sacred-places-list')
            </div>
        </div>
    </div>
@endsection

<style>
    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }

    .scrollbar-hide {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
</style>