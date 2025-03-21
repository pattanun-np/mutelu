@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="relative">
                    <img
                        src="{{ $sacredplace->image }}"
                        alt="{{ $sacredplace->name }}"
                        class="w-full h-64 object-cover"
                    >
                    <div class="absolute top-0 right-0 p-4 flex space-x-2">
                        <a
                            href="{{ route('sacredplaces.edit', $sacredplace) }}"
                            class="bg-rose-500 text-white px-4 py-2 rounded-lg hover:bg-rose-600"
                        >
                            Edit
                        </a>
                        <form
                            action="{{ route('sacredplaces.destroy', $sacredplace) }}"
                            method="POST"
                            onsubmit="return confirm('Are you sure you want to delete this sacred place?');"
                        >
                            @csrf
                            @method('DELETE')
                            <button
                                type="submit"
                                class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600"
                            >
                                Delete
                            </button>
                        </form>
                    </div>
                </div>

                <div class="p-6">
                    <h1 class="text-3xl font-bold mb-4">{{ $sacredplace->name }}</h1>

                    <div class="flex flex-wrap gap-2 mb-4">
                        @if($sacredplace->tags->isNotEmpty())
                            @foreach($sacredplace->tags as $tag)
                                <span class="bg-rose-100 text-rose-800 text-sm px-3 py-1 rounded-full">
                                    {{ $tag->name }}
                                </span>
                            @endforeach
                        @else
                            <span class="text-gray-500">No tags</span>
                        @endif
                    </div>

                    <div class="mb-6">
                        <h2 class="text-xl font-semibold mb-2">Description</h2>
                        <p class="text-gray-700">{{ $sacredplace->description }}</p>
                    </div>

                    <div class="mb-6">
                        <h2 class="text-xl font-semibold mb-2">Location</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-gray-600">Latitude: <span
                                        class="font-medium">{{ $sacredplace->latitude }}</span></p>
                            </div>
                            <div>
                                <p class="text-gray-600">Longitude: <span
                                        class="font-medium">{{ $sacredplace->longitude }}</span></p>
                            </div>
                        </div>
                        <div class="mt-4 h-64 rounded-lg">
                            <!-- Google Map with marker -->
                            <div
                                id="map"
                                class="w-full h-full rounded-lg"
                            ></div>
                        </div>
                    </div>

                    <div class="mb-6">
                        <h2 class="text-xl font-semibold mb-4">Reviews</h2>
                        <div class="flex justify-between items-center mb-4">
                            <p class="text-gray-600">{{ $sacredplace->reviews->count() }} {{ Str::plural('review', $sacredplace->reviews->count()) }}</p>

                            @if(session()->has('user_id'))
                                @php
    $userReview = $sacredplace->reviews->where('user_id', session('user_id'))->first();
                                @endphp

                                @if($userReview)
                                    <a href="{{ route('reviews.edit', $userReview) }}" class="bg-rose-600 hover:bg-rose-700 text-white font-medium py-2 px-4 rounded-lg shadow-sm transition-colors">
                                        Edit Your Review
                                    </a>
                                @else
                                    <a href="{{ route('reviews.create', ['sacredplace_id' => $sacredplace->id]) }}" class="bg-rose-600 hover:bg-rose-700 text-white font-medium py-2 px-4 rounded-lg shadow-sm transition-colors">
                                        Write a Review
                                    </a>
                                @endif
                            @else
                                <a href="{{ route('login') }}" class="bg-rose-600 hover:bg-rose-700 text-white font-medium py-2 px-4 rounded-lg shadow-sm transition-colors">
                                    Login to Write a Review
                                </a>
                            @endif
                        </div>

                        @if($sacredplace->reviews->count() > 0)
                            <div class="space-y-6">
                                @foreach($sacredplace->reviews as $review)
                                    <div class="border-b border-gray-200 pb-6">
                                        <div class="flex justify-between items-start mb-2">
                                            <div>
                                                <h3 class="font-semibold text-lg">{{ $review->title }}</h3>
                                                <p class="text-sm text-gray-500">
                                                    By {{ $review->user ? $review->user->name : 'Unknown User' }} on {{ $review->created_at->format('M d, Y') }}
                                                </p>
                                            </div>
                                            <div class="flex">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <span class="{{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }} text-xl">★</span>
                                                @endfor
                                            </div>
                                        </div>
                                        <p class="text-gray-700">{{ $review->body }}</p>

                                        @if(session()->has('user_id') && $review->user_id == session('user_id'))
                                            <div class="mt-2 flex justify-end">
                                                <a href="{{ route('reviews.edit', $review) }}" class="text-sm text-rose-600 hover:text-rose-800">
                                                    Edit your review
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500 py-4">No reviews yet. Be the first to write a review!</p>
                        @endif
                    </div>

                    <div class="flex justify-between">
                        <a
                            href="{{ route('home') }}"
                            class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400"
                        >
                            Back to Home
                        </a>
                        <a
                            href="{{ route('sacredplaces.create') }}"
                            class="px-4 py-2 bg-rose-500 text-white rounded-lg hover:bg-rose-600"
                        >
                            Add New Sacred Place
                        </a>
                    </div>
                    </div>
                    </div>
                    </div>
                    </div>
    <!-- Google Maps JavaScript -->
    <script>
        function initMap() {
            // Get the sacred place coordinates
            const lat = {{ $sacredplace->latitude ?? 0 }};
            const lng = {{ $sacredplace->longitude ?? 0 }};
            const name = "{{ $sacredplace->name }}";

            // Check if coordinates are valid
            if (lat === 0 && lng === 0) {
                // Display a message if coordinates are missing
                document.getElementById("map").innerHTML = '<div class="flex items-center justify-center h-full bg-gray-200 rounded-lg"><p class="text-gray-500">Location coordinates not available</p></div>';
                return;
            }

            // Create a LatLng object
            const position = { lat: lat, lng: lng };

            // Create the map centered at the sacred place
            const map = new google.maps.Map(document.getElementById("map"), {
                zoom: 14,
                center: position,
                mapTypeId: "terrain",
            });

            // Add a marker at the sacred place location
            const marker = new google.maps.Marker({
                position: position,
                map: map,
                title: name,
                animation: google.maps.Animation.DROP
            });

            // Add an info window with the sacred place name
            const infoWindow = new google.maps.InfoWindow({
                content: `<div class="p-1"><strong>${name}</strong></div>`
            });

            // Open the info window when the marker is clicked
            marker.addListener("click", () => {
                infoWindow.open(map, marker);
            });

            // Open the info window by default
            infoWindow.open(map, marker);
        }
    </script>

    <!-- Load the Google Maps JavaScript API with your API key -->
    <script
        src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_maps.api_key') }}&callback=initMap"
        async
        defer
    ></script>
@endsection