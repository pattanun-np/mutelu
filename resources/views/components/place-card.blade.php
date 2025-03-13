<div
    class="group h-full rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-all duration-300 bg-white place-card">
    <a
        href="{{ route('sacredplaces.show', $place->slug ?? $place->id) }}"
        class="block h-full flex flex-col"
    >
        <div class="relative pt-[75%] overflow-hidden bg-gray-100 rounded-t-xl">
            <img
                src="{{ $filteredImages[0] }}"
                alt="{{ $place->name }}"
                class="absolute inset-0 w-full h-full object-cover transition duration-300 group-hover:scale-105"
                loading="lazy"
                onerror="this.onerror=null; this.src='/images/placeholder.jpg';"
            >
            <button class="absolute top-3 right-3 p-2 rounded-full bg-white/80 hover:bg-white shadow-sm">
                <svg
                    class="h-5 w-5 text-rose-500"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"
                    />
                </svg>
            </button>
        </div>
        <div class="p-4 flex-grow flex flex-col">
            <div class="flex justify-between items-start mb-1">
                <h3 class="font-medium text-lg text-gray-900 line-clamp-1">
                    {{ $place->name }}
                </h3>
                <div class="flex items-center text-sm">
                    <svg
                        class="h-4 w-4 text-rose-500 mr-1"
                        fill="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"
                        />
                    </svg>
                    <span>5.0</span>
                </div>
                </div>
                <p class="text-gray-600 text-sm mb-1">
                    {{ $place->location ?? 'Sacred Location' }}
                </p>
                <p class="text-gray-500 text-sm line-clamp-2 mb-2">
                    {{ $place->description ?? 'No description available' }}
                </p>
                <div class="mt-auto pt-2 border-t border-gray-100">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <span class="text-sm font-medium text-rose-500">Sacred Place</span>
                        </div>
                        <div class="text-sm font-medium text-gray-900">
                            New
                        </div>
                </div>
            </div>
        </div>
    </a>
</div>