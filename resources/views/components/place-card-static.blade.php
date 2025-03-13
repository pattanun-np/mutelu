<div
    class="h-full rounded-xl overflow-hidden shadow-sm hover:shadow-md transition duration-300 bg-white">
    <a
        href="{{ route('sacredplaces.show', $place->id) }}"
        class="block h-full flex flex-col"
    >
        <div class="relative pt-[66.67%] overflow-hidden bg-gray-100">
            @if(isset($place->image) && $place->image)
                <img
                    src="{{ $place->image }}"
                    alt="{{ $place->name }}"
                    class="absolute inset-0 w-full h-full object-cover transition duration-300 hover:scale-105"
                    loading="lazy"
                    onerror="this.onerror=null; this.src='/images/placeholder.jpg';"
                >
            @else
                <img
                    src="/images/placeholder.jpg"
                    alt="{{ $place->name }}"
                    class="absolute inset-0 w-full h-full object-cover transition duration-300 hover:scale-105"
                    loading="lazy"
                >
            @endif
        </div>
        <div class="p-4 flex-grow flex flex-col">
            <h3 class="font-semibold text-lg text-gray-900 mb-1 line-clamp-1">
                {{ $place->name }}
            </h3>
            <p class="text-gray-600 text-sm mb-2">
                {{ $place->location ?? 'Location not specified' }}
            </p>
            <p class="text-gray-500 text-sm line-clamp-2 mb-4">
                {{ $place->description ?? 'No description available' }}
            </p>
            <div class="mt-auto flex items-center justify-between">
                <div class="flex items-center">
                    <svg
                        class="h-4 w-4 text-rose-500"
                        fill="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"
                        />
                    </svg>
                    <span class="ml-1 text-sm text-gray-600">New</span>
                </div>
                <div class="text-sm font-semibold text-gray-900">
                    Sacred Place
                </div>
            </div>
        </div>
    </a>
</div>