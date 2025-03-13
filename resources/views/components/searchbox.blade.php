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
    <div class="bg-white rounded-full shadow-lg  transition-all duration-300 ease-in-out" id="searchbox">
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

            <!-- Guests Selector and Search Button -->
         
           
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
