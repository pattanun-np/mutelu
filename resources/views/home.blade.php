@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <div class="bg-white">
        <!-- Hero Section -->
        <div class="relative bg-gradient-to-r from-rose-50 to-rose-100 py-16">
            <div class="container mx-auto px-4">
                <div class="max-w-3xl mx-auto text-center">
                    <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">Discover Sacred Places
                    </h1>
                    <p class="text-xl text-gray-700 mb-8">Find spiritual destinations and connect with
                        sacred sites around the world</p>

                    <!-- Search Bar -->
                    <div class="relative max-w-2xl mx-auto">
                        <form
                            action="{{ route('sacredplaces.index') }}"
                            method="GET"
                            class="flex items-center"
                        >
                            <div class="relative flex-grow">
                                <input
                                    type="text"
                                    name="search"
                                    placeholder="Search sacred places..."
                                    class="w-full py-4 pl-5 pr-12 text-gray-900 bg-white rounded-l-full border-0 shadow-lg focus:ring-2 focus:ring-rose-500 focus:outline-none"
                                >
                                <div
                                    class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <svg
                                        class="w-5 h-5 text-gray-400"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                                        ></path>
                                    </svg>
                                </div>
                            </div>
                            <button
                                type="submit"
                                class="bg-rose-500 hover:bg-rose-600 text-white py-4 px-6 rounded-r-full shadow-lg transition-colors"
                            >
                                Search
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Decorative Elements -->
            <div class="absolute bottom-0 left-0 w-full overflow-hidden">
                <svg
                    class="fill-current text-white"
                    viewBox="0 0 1200 120"
                    preserveAspectRatio="none"
                >
                    <path
                        d="M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z"
                    ></path>
                </svg>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="sticky top-16 z-10 bg-white border-b border-gray-200 py-4 px-4 shadow-sm">
            <div class="container mx-auto">
                <div class="flex items-center space-x-4 overflow-x-auto pb-2 scrollbar-hide">
                    <button
                        data-filter="all"
                        class="bg-gray-900 text-white px-4 py-2 rounded-full text-sm font-medium"
                    >
                        All Places
                    </button>
                    <button
                        data-filter="temple"
                        class="bg-white text-gray-800 hover:bg-gray-100 px-4 py-2 rounded-full text-sm font-medium border border-gray-200"
                    >
                        Temples
                    </button>
                    <button
                        data-filter="church"
                        class="bg-white text-gray-800 hover:bg-gray-100 px-4 py-2 rounded-full text-sm font-medium border border-gray-200"
                    >
                        Churches
                    </button>
                    <button
                        data-filter="mosque"
                        class="bg-white text-gray-800 hover:bg-gray-100 px-4 py-2 rounded-full text-sm font-medium border border-gray-200"
                    >
                        Mosques
                    </button>
                    <button
                        data-filter="shrine"
                        class="bg-white text-gray-800 hover:bg-gray-100 px-4 py-2 rounded-full text-sm font-medium border border-gray-200"
                    >
                        Shrines
                    </button>
                    <button
                        data-filter="historical"
                        class="bg-white text-gray-800 hover:bg-gray-100 px-4 py-2 rounded-full text-sm font-medium border border-gray-200"
                    >
                        Historical
                    </button>
                    <button
                        data-filter="natural"
                        class="bg-white text-gray-800 hover:bg-gray-100 px-4 py-2 rounded-full text-sm font-medium border border-gray-200"
                    >
                        Natural
                    </button>
                    <button
                        class="bg-white text-gray-800 hover:bg-gray-100 px-4 py-2 rounded-full text-sm font-medium border border-gray-200 flex items-center"
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
                        Filters
                    </button>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="container mx-auto px-4 py-8">
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-2xl font-bold text-gray-900">Sacred Places</h2>
                <a href="{{ route('sacredplaces.create') }}"
                    class="bg-rose-500 hover:bg-rose-600 text-white px-4 py-2 rounded-lg shadow-sm transition-colors"
                >
                    Add New Place
                    </a>
                    </div>

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

