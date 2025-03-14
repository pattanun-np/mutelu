<div
    x-data="{
        isCompact: false,
        searchQuery: ''
    }"
    class="w-full"
>
    <div
        class="bg-white rounded-full shadow-sm hover:shadow-md border border-gray-200 transition-all duration-300 ease-in-out w-full"
        id="searchbox"
    >
        <form
            method="GET"
            action="{{ route('sacredplaces.index') }}"
            class="flex items-center"
            @submit="if (typeof Livewire !== 'undefined' && document.querySelector('[wire\\:id]')) { Livewire.dispatch('searchUpdated', searchQuery); }"
        >
            <!-- Search Input -->
            <div class="px-4 py-2 cursor-pointer relative flex-1 min-w-0 flex items-center">
                <div class="flex-1 relative">
                    <input
                        type="text"
                        id="search-input"
                        name="search"
                        placeholder="Search sacred places..."
                        class="w-full bg-transparent border-0 p-0 focus:ring-0 text-sm text-gray-600 placeholder-gray-400 transition-all duration-300"
                        x-model="searchQuery"
                    >
                </div>
            </div>

            <!-- Search Button -->
            <div class="pr-1">
                <button
                    type="submit"
                    class="bg-gradient-to-r from-rose-500 to-rose-600 hover:from-rose-600 hover:to-rose-700 text-white p-2 rounded-full font-medium flex items-center justify-center transition-all duration-300 hover:scale-105"
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
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                        />
                    </svg>
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    #searchbox:hover {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }
    
    #search-input:focus {
        outline: none;
    }
    
    /* Pulse animation for the search button */
    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.25); }
        100% { transform: scale(1); }
    }
    
    button[type="submit"]:hover {
        animation: pulse 1.5s infinite;
    }
</style>