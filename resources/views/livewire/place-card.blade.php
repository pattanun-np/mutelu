<div>
    <div
        class="rounded-xl overflow-hidden transition duration-200 hover:-translate-y-0.5"
        wire:init="loadPlace"
    >
        <a
            href="{{ route('sacredplaces.show', $place->id) }}"
            class="block"
        >
            <div
                class="relative pt-[100%] overflow-hidden rounded-xl group"
                x-data="{ isHovering: false }"
                @mouseenter="isHovering = true"
                @mouseleave="isHovering = false"
            >
                <!-- Skeleton loader for image -->
                <div
                    wire:loading.delay
                    class="absolute inset-0 bg-gray-200 animate-pulse rounded-xl"
                ></div>

                <button
                    class="absolute top-1 right-1 z-10 p-2 bg-none bg-opacity-70 rounded-full hover:bg-opacity-90 transition duration-200 focus:outline-none"
                    aria-label="Add to favorites"
                    wire:loading.remove
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-8 w-8 text-white fill-gray-900/50 rounded-full hover:text-rose-500 hover:scale-110
                                                                         transition duration-200 hover:fill-rose-500 hover:bg-red-500/10"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        wire:click.stop.prevent="toggleFavorite"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"
                        />
                    </svg>
                </button>
                <!-- Left arrow -->
                <button
                    class="absolute left-2 top-1/2 -translate-y-1/2 bg-white/90 rounded-full p-1.5 shadow-md hover:bg-white transition z-10 opacity-0 group-hover:opacity-100"
                    x-show="isHovering && imageIndex > 0"
                    wire:click.stop.prevent="previousImage"
                    wire:loading.remove
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 transform translate-x-2"
                    x-transition:enter-end="opacity-100 transform translate-x-0"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-4 w-4"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M15 19l-7-7 7-7"
                        />
                    </svg>
                </button>

                <!-- Right arrow -->
                <button
                    class="absolute right-2 top-1/2 -translate-y-1/2 bg-white/90 rounded-full p-1.5 shadow-md hover:bg-white transition z-10 opacity-0 group-hover:opacity-100"
                    x-show="isHovering && imageIndex < filteredImages.length - 1"
                    wire:click.stop.prevent="nextImage"
                    wire:loading.remove
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 transform -translate-x-2"
                    x-transition:enter-end="opacity-100 transform translate-x-0"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-4 w-4"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M9 5l7 7-7 7"
                        />
                    </svg>
                </button>

                <!-- Image carousel -->
                <div
                    class="absolute inset-0 w-full h-ful"
                    wire:loading.remove
                >
                    <div
                        class="relative w-full h-full flex transition-transform duration-300 ease-out"
                        style="transform: translateX(-{{ $imageIndex * 100 }}%)"
                    >
                        @foreach($filteredImages as $index => $image)
                            <div
                                class="absolute top-0 left-0 w-full h-full flex-shrink-0"
                                style="left: {{ $index * 100 }}%"
                            >
                                <img
                                    src="{{ $image }}"
                                    alt="{{ $place->name }} - Image {{ $index + 1 }}"
                                    class="w-full h-full object-cover object-center transition duration-300 hover:scale-105"
                                >
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Dots indicator -->
                <div
                    class="absolute bottom-2 left-0 right-0 flex justify-center space-x-1.5"
                    wire:loading.remove
                >
                    @foreach($filteredImages as $index => $image)
                        <button
                            wire:click.stop.prevent="setImageIndex({{ $index }})"
                            class="w-1.5 h-1.5 rounded-full transition-all duration-200 focus:outline-none {{ $imageIndex === $index ? 'bg-white scale-110 w-2 h-2' : 'bg-white/50' }}"
                        ></button>
                    @endforeach
                </div>
            </div>
            <div class="py-4">
                <!-- Skeleton loader for text -->
                <div
                    wire:loading.delay
                    class="space-y-2"
                >
                    <div class="h-5 bg-gray-200 rounded animate-pulse w-3/4"></div>
                    <div class="h-4 bg-gray-200 rounded animate-pulse w-1/2"></div>
                    <div class="h-4 bg-gray-200 rounded animate-pulse w-full"></div>
                    <div class="h-4 bg-gray-200 rounded animate-pulse w-2/3"></div>
                </div>

                <div wire:loading.remove>
                    <h3
                        class="font-semibold text-base text-gray-700 m-0 mb-1 whitespace-nowrap overflow-hidden text-ellipsis">
                        {{ $place->name }}
                    </h3>
                    <p class="text-gray-500 m-0 mb-2 text-sm">
                        {{ $place->location ?? $place->city ?? 'Location not specified' }}
                    </p>
                    <p class="text-gray-500 m-0 text-sm line-clamp-2 overflow-hidden">
                        {{ $place->description ?? 'No description available' }}
                    </p>
                </div>
            </div>
        </a>
    </div>
</div>