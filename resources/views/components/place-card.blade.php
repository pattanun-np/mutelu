<div class="place-card">
    <a
        href="{{ route('sacredplaces.show', $place->id) }}"
        class="block h-full"
    >
        <div class="place-image-container">
            <img
                src="{{ $filteredImages[0] }}"
                alt="{{ $place->name }}"
                class="place-image"
            >
        </div>
        <div class="place-info">
            <h3 class="place-name">
                {{ $place->name }}
            </h3>
            <p class="place-location">
                {{ $place->location ?? 'Location not specified' }}
            </p>
            <p class="place-description">
                {{ $place->description ?? 'No description available' }}
            </p>
        </div>
    </a>
</div>