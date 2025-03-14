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

        <!-- Filter Section -->
        <div class="sticky top-16 z-10 bg-white border-b border-gray-200 py-4 px-4 shadow-sm">
            <div class="container mx-auto">
                <div class="flex items-center space-x-4 overflow-x-auto pb-2 scrollbar-hide">
                    <button
                        data-filter="all"
                        class="filter-button bg-gray-900 text-white px-4 py-2 rounded-full text-sm font-medium"
                    >
                        All Places
                    </button>
                    <button
                        data-filter="Temple"
                        class="filter-button bg-white text-gray-800 hover:bg-gray-100 px-4 py-2 rounded-full text-sm font-medium border border-gray-200"
                    >
                        Temples
                    </button>
                    <button
                        data-filter="Church"
                        class="filter-button bg-white text-gray-800 hover:bg-gray-100 px-4 py-2 rounded-full text-sm font-medium border border-gray-200"
                    >
                        Churches
                    </button>
                    <button
                        data-filter="Mosque"
                        class="filter-button bg-white text-gray-800 hover:bg-gray-100 px-4 py-2 rounded-full text-sm font-medium border border-gray-200"
                    >
                        Mosques
                    </button>
                    <button
                        data-filter="Shrine"
                        class="filter-button bg-white text-gray-800 hover:bg-gray-100 px-4 py-2 rounded-full text-sm font-medium border border-gray-200"
                    >
                        Shrines
                    </button>
                    <button
                        data-filter="Historical"
                        class="filter-button bg-white text-gray-800 hover:bg-gray-100 px-4 py-2 rounded-full text-sm font-medium border border-gray-200"
                    >
                        Historical
                    </button>
                    <button
                        data-filter="Natural"
                        class="filter-button bg-white text-gray-800 hover:bg-gray-100 px-4 py-2 rounded-full text-sm font-medium border border-gray-200"
                    >
                        Natural
                    </button>
                    <button
                        id="clear-filters"
                        class="filter-button bg-white text-gray-800 hover:bg-gray-100 px-4 py-2 rounded-full text-sm font-medium border border-gray-200 flex items-center"
                    >
                        <svg
                            class="w-4 h-4 mr-2"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"
                            ></path>
                        </svg>
                        Clear Filters
                        <span
                            id="active-filters-count"
                            class="ml-2 bg-rose-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center hidden"
                        >0</span>
                    </button>
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