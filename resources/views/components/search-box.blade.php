<div
    class="container mx-auto px-6 py-4 flex justify-center items-center sticky top-0 z-10"
    id="searchbox-container"
    x-data="{
        isVisible: true,
        isCompact: false,
        isHidden: false,
        lastScrollPosition: 0,
        searchQuery: ''
    }"
    x-init="
        $watch('isCompact', value => {
            if (value) {
                $el.querySelector('#searchbox').classList.add('scale-95', 'shadow-md');
                $el.querySelector('#search-label').classList.add('hidden');
                $el.querySelector('#search-input').classList.add('py-1');
            } else {
                $el.querySelector('#searchbox').classList.remove('scale-95', 'shadow-md');
                $el.querySelector('#search-label').classList.remove('hidden');
                $el.querySelector('#search-input').classList.remove('py-1');
            }
        });
        
        $watch('isHidden', value => {
            if (value) {
                $el.querySelector('#searchbox').classList.add('-translate-y-full', 'opacity-0');
                setTimeout(() => {
                    if (isHidden) $el.classList.add('invisible');
                }, 300);
            } else {
                $el.classList.remove('invisible');
                setTimeout(() => {
                    $el.querySelector('#searchbox').classList.remove('-translate-y-full', 'opacity-0');
                }, 50);
            }
        });
        
        // Initialize animation
        const searchbox = $el.querySelector('#searchbox');
        searchbox.style.opacity = '0';
        searchbox.style.transform = 'translateY(20px)';
        
        setTimeout(() => {
            searchbox.style.transition = 'all 0.5s ease-out';
            searchbox.style.opacity = '1';
            searchbox.style.transform = 'translateY(0)';
        }, 100);
    "
    @scroll.window="
        let scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        
        if (scrollTop > lastScrollPosition && scrollTop > 20) {
            isCompact = true;
            if (scrollTop > 100) {
                isHidden = true;
            }
        } else if (scrollTop < lastScrollPosition) {
            isHidden = false;
            if (scrollTop <= 20) {
                isCompact = false;
            }
        }
        
        lastScrollPosition = scrollTop;
    "
>

    <div
        class="bg-white rounded-full shadow-lg transition-all duration-300 ease-in-out w-full max-w-2xl"
        id="searchbox"
    >
        <form
            method="GET"
            action="{{ route('sacredplaces.index') }}"
            class="flex items-center"
        >
            <!-- Search Input -->
            <div class="px-6 py-3 cursor-pointer relative flex-1 min-w-0 flex items-center">
                <label
                    id="search-label"
                    for="search"
                    class="block text-xs font-bold text-gray-900 mb-1 transition-opacity duration-300"
                >
                    Find Sacred Places
                </label>
                <div class="flex-1 relative">
                    <input
                        type="text"
                        id="search-input"
                        name="search"
                        placeholder="Search sacred places by name, description or tags"
                        class="w-full bg-transparent border-0 p-0 focus:ring-0 text-sm text-gray-600 placeholder-gray-400 transition-all duration-300"
                        x-model="searchQuery"
                    >
                </div>
            </div>

            <!-- Search Button -->
            <div class="pr-2">
                <button
                    type="submit"
                    class="bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white p-3 rounded-full font-medium flex items-center justify-center transition-all duration-300 hover:scale-105"
                    x-bind:class="{'p-2': isCompact, 'p-3': !isCompact}"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5"
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
    .scale-95 {
        transform: scale(0.95);
    }

    .-translate-y-full {
        transform: translateY(-100%);
    }

    .opacity-0 {
        opacity: 0;
    }

    .invisible {
        visibility: hidden;
    }

    #searchbox {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }

    #searchbox:hover {
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.12);
    }

    #search-input:focus {
        outline: none;
    }

    /* Pulse animation for the search button */
    @keyframes pulse {
        0% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.05);
        }

        100% {
            transform: scale(1);
        }
    }

    button[type="submit"]:hover {
        animation: pulse 1.5s infinite;
    }
</style>