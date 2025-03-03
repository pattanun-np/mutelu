<div class="bg-white shadow-lg rounded-lg overflow-hidden">
    <img
        src=""
        alt="{{ $accommodation->title }}"
        class="w-full h-56 object-cover"
    >
    <div class="p-4">
        {{-- <h2 class="text-lg font-semibold">{{ $accommodation->title }}</h2>
        <p class="text-gray-600">{{ $accommodation->location }}</p> --}}
        <p class="mt-2 text-gray-800 font-bold">
            ${{ number_format($accommodation->price_per_night, 2) }} / night</p>
        <a
            href="{{ route('accommodations.show', $accommodation->id) }}"
            class="block mt-4 text-blue-500 hover:underline"
        >
            View Details
        </a>
    </div>
</div>