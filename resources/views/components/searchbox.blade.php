<div class="container mx-auto px-6 py-8 flex justify-center items-center sticky top-0 z-10" id="searchbox-container"
    x-data="{
        isVisible: true,
        isCompact: false,
        isHidden: false,
        activeTab: 'location',
        guestPopupOpen: false,
        adults: 0,
        children: 0,
        infants: 0,
        pets: 0,
        lastScrollPosition: 0
    }" x-init="$watch('isCompact', value => {
        if (value) {
            $el.querySelector('#searchbox').classList.add('scale-95', 'shadow-md');
            $el.querySelectorAll('.label-element').forEach(el => el.classList.add('hidden'));
            $el.querySelectorAll('.compact-text').forEach(el => el.classList.remove('hidden'));
            $el.querySelectorAll('.input-field').forEach(el => el.classList.add('py-1'));
        } else {
            $el.querySelector('#searchbox').classList.remove('scale-95', 'shadow-md');
            $el.querySelectorAll('.label-element').forEach(el => el.classList.remove('hidden'));
            $el.querySelectorAll('.compact-text').forEach(el => el.classList.add('hidden'));
            $el.querySelectorAll('.input-field').forEach(el => el.classList.remove('py-1'));
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
    
    // Initialize Framer Motion animations
    if (typeof window.framerMotion !== 'undefined') {
        const { motion, animate } = window.framerMotion;
        const searchbox = $el.querySelector('#searchbox');
    
        // Apply initial animation when component loads
        animate(searchbox, { y: [20, 0], opacity: [0, 1] }, { duration: 0.5, ease: 'easeOut' });
    }"
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
    @click.away="guestPopupOpen = false">
    <div class="bg-white rounded-full shadow-lg transition-all duration-300 ease-in-out" id="searchbox">
        <form method="GET" class="flex items-center divide-x divide-gray-200">
            <!-- Location Input -->
            <div class="px-6 py-3 cursor-pointer relative flex-1 min-w-0"
                @click="activeTab = 'location'; guestPopupOpen = false"
                :class="{ 'bg-gray-100 rounded-l-full': activeTab === 'location' }">
                <label for="location"
                    class="block text-xs font-bold text-gray-900 mb-1 label-element transition-opacity duration-300">Where</label>
                <input type="text" id="location" name="location" placeholder="Search destinations"
                    class="w-full bg-transparent border-0 p-0 focus:ring-0 text-sm text-gray-600 placeholder-gray-400 input-field transition-opacity duration-300"
                    :class="{ 'font-medium': activeTab === 'location' }">
                <span class="hidden compact-text text-sm font-medium transition-opacity duration-300">Anywhere</span>
            </div>

            <!-- Check-in Date -->
            <div class="px-6 py-3 cursor-pointer relative flex-1 min-w-0"
                @click="activeTab = 'checkin'; guestPopupOpen = false"
                :class="{ 'bg-gray-100': activeTab === 'checkin' }">
                <label for="check_in"
                    class="block text-xs font-bold text-gray-900 mb-1 label-element transition-opacity duration-300">Check
                    in</label>
                <input type="date" id="check_in" name="check_in"
                    class="w-full bg-transparent border-0 p-0 focus:ring-0 text-sm text-gray-600 input-field transition-opacity duration-300"
                    :class="{ 'font-medium': activeTab === 'checkin' }">
                <span class="hidden compact-text text-sm font-medium transition-opacity duration-300">Add dates</span>
            </div>

            <!-- Check-out Date -->
            <div class="px-6 py-3 cursor-pointer relative flex-1 min-w-0"
                @click="activeTab = 'checkout'; guestPopupOpen = false"
                :class="{ 'bg-gray-100': activeTab === 'checkout' }">
                <label for="check_out"
                    class="block text-xs font-bold text-gray-900 mb-1 label-element transition-opacity duration-300">Check
                    out</label>
                <input type="date" id="check_out" name="check_out"
                    class="w-full bg-transparent border-0 p-0 focus:ring-0 text-sm text-gray-600 input-field transition-opacity duration-300"
                    :class="{ 'font-medium': activeTab === 'checkout' }">
                <span class="hidden compact-text text-sm font-medium transition-opacity duration-300">Add dates</span>
            </div>

            <!-- Guests Selector and Search Button -->
            <div class="pl-6 pr-2 py-2 flex items-center justify-between rounded-r-full min-w-0 relative"
                :class="{ 'bg-gray-100': activeTab === 'guests' }">
                <div class="cursor-pointer pr-2" @click="activeTab = 'guests'; guestPopupOpen = !guestPopupOpen">
                    <label for="guests"
                        class="block text-xs font-bold text-gray-900 mb-1 label-element transition-opacity duration-300">Who</label>
                    <div class="w-full bg-transparent border-0 p-0 text-sm text-gray-600 input-field transition-opacity duration-300"
                        :class="{ 'font-medium': activeTab === 'guests' }">
                        <span
                            x-text="adults + children + infants + pets > 0 ? 
                            (adults + children + infants + pets) + ' guest' + (adults + children + infants + pets > 1 ? 's' : '') : 
                            'Add guests'"></span>
                        <input type="hidden" name="adults" :value="adults">
                        <input type="hidden" name="children" :value="children">
                        <input type="hidden" name="infants" :value="infants">
                        <input type="hidden" name="pets" :value="pets">
                    </div>
                    <span class="hidden compact-text text-sm font-medium transition-opacity duration-300">Add
                        guests</span>
                </div>

                <!-- Guest Popup -->
                <div x-show="guestPopupOpen" x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                    class="absolute top-full right-0 mt-2 bg-white rounded-2xl shadow-xl p-6 w-80 z-20"
                    style="display: none;">
                    <!-- Adults -->
                    <div class="flex items-center justify-between py-4 border-b border-gray-200">
                        <div>
                            <h3 class="text-base font-semibold">Adults</h3>
                            <p class="text-sm text-gray-500">Ages 13 or above</p>
                        </div>
                        <div class="flex items-center">
                            <button type="button"
                                class="w-8 h-8 rounded-full border border-gray-300 flex items-center justify-center text-gray-500 disabled:opacity-50"
                                :disabled="adults <= 0" @click="adults = Math.max(0, adults - 1)">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd" d="M3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                            <span class="w-8 text-center" x-text="adults"></span>
                            <button type="button"
                                class="w-8 h-8 rounded-full border border-gray-300 flex items-center justify-center text-gray-500"
                                @click="adults++">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Children -->
                    <div class="flex items-center justify-between py-4 border-b border-gray-200">
                        <div>
                            <h3 class="text-base font-semibold">Children</h3>
                            <p class="text-sm text-gray-500">Ages 2 – 12</p>
                        </div>
                        <div class="flex items-center">
                            <button type="button"
                                class="w-8 h-8 rounded-full border border-gray-300 flex items-center justify-center text-gray-500 disabled:opacity-50"
                                :disabled="children <= 0" @click="children = Math.max(0, children - 1)">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd" d="M3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                            <span class="w-8 text-center" x-text="children"></span>
                            <button type="button"
                                class="w-8 h-8 rounded-full border border-gray-300 flex items-center justify-center text-gray-500"
                                @click="children++">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Infants -->
                    <div class="flex items-center justify-between py-4 border-b border-gray-200">
                        <div>
                            <h3 class="text-base font-semibold">Infants</h3>
                            <p class="text-sm text-gray-500">Under 2</p>
                        </div>
                        <div class="flex items-center">
                            <button type="button"
                                class="w-8 h-8 rounded-full border border-gray-300 flex items-center justify-center text-gray-500 disabled:opacity-50"
                                :disabled="infants <= 0" @click="infants = Math.max(0, infants - 1)">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd" d="M3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                            <span class="w-8 text-center" x-text="infants"></span>
                            <button type="button"
                                class="w-8 h-8 rounded-full border border-gray-300 flex items-center justify-center text-gray-500"
                                @click="infants++">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                <button type="submit"
                    class="bg-gradient-to-r from-rose-500 to-pink-600 hover:from-rose-600 hover:to-pink-700 text-white p-3 rounded-full font-medium flex items-center justify-center transition-all duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>
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

    /* Make date inputs look more like regular text */
    input[type="date"]::-webkit-calendar-picker-indicator {
        opacity: 0.6;
    }

    /* Custom animation classes */
    .airbnb-expand {
        transform-origin: center top;
    }
</style>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.store('scroll', {
            lastPosition: 0
        });
    });

    // Framer Motion integration
    document.addEventListener('DOMContentLoaded', () => {
        if (typeof window.framerMotion !== 'undefined') {
            const {
                animate,
                stagger
            } = window.framerMotion;

            // Add hover animations to search button
            const searchButton = document.querySelector('button[type="submit"]');
            if (searchButton) {
                searchButton.addEventListener('mouseenter', () => {
                    animate(searchButton, {
                        scale: 1.05
                    }, {
                        duration: 0.2
                    });
                });

                searchButton.addEventListener('mouseleave', () => {
                    animate(searchButton, {
                        scale: 1
                    }, {
                        duration: 0.2
                    });
                });
            }

            // Add staggered animations to each section
            const inputSections = document.querySelectorAll('form > div');
            animate(inputSections, {
                opacity: [0, 1],
                y: [5, 0]
            }, {
                delay: stagger(0.08),
                duration: 0.4,
                ease: "easeOut"
            });

            // Add pulse animation to the search box on load
            const searchbox = document.getElementById('searchbox');
            if (searchbox) {
                animate(searchbox,
                    [{
                            scale: 0.95,
                            opacity: 0
                        },
                        {
                            scale: 1.02,
                            opacity: 0.8
                        },
                        {
                            scale: 1,
                            opacity: 1
                        }
                    ], {
                        duration: 0.6,
                        ease: "easeOut"
                    }
                );
            }
        }
    });
</script>
