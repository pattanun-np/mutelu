<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >
    <title>{{ config('app.name', 'Sacred Places') }}</title>
    <!-- CSRF Token -->
    <meta
        name="csrf-token"
        content="{{ csrf_token() }}"
    >
    <!-- Ensure CSRF token is available for JavaScript -->
    <script>
        window.Laravel = {!! json_encode(['csrfToken' => csrf_token()]) !!};
    </script>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Instrument Sans', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                    },
                    colors: {
                        primary: '#3B82F6',
                        secondary: '#10B981',
                    },
                }
            }
        }
    </script>
    
    <!-- Fonts -->
    <link
        rel="preconnect"
        href="https://fonts.googleapis.com"
    >
    <link
        rel="preconnect"
        href="https://fonts.gstatic.com"
        crossorigin
    >
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap"
        rel="stylesheet"
    >
    
    <!-- Alpine JS -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.1/dist/cdn.min.js"></script>
    
    <!-- Ensure Alpine.js is loaded -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (typeof Alpine === 'undefined') {
                console.error('Alpine.js is not loaded properly');
                // Try to load Alpine.js again
                const script = document.createElement('script');
                script.src = 'https://cdn.jsdelivr.net/npm/alpinejs@3.14.1/dist/cdn.min.js';
                document.head.appendChild(script);
            } else {
                console.log('Alpine.js is loaded properly');
            }
        });
    </script>
    <!-- Framer Motion -->
    <script src="https://unpkg.com/framer-motion@10.16.4/dist/framer-motion.js"></script>
    
    <!-- Animation Utilities -->
    <script>
        document.addEventListener('alpine:init', () => {
            // Initialize Alpine store
            Alpine.store('scroll', {
                lastPosition: 0
            });

            // Create Alpine data for animations
            Alpine.data('pageTransition', () => ({
                show: false,
                isCompactSearch: false,
                init() {
                    this.show = true;
                },
                handleScroll() {
                    // Handle scroll events for search box transformation
                    const scrollY = window.scrollY;
                    const searchbox = document.getElementById('searchbox');
                    
                    if (scrollY > 100 && !this.isCompactSearch) {
                        this.isCompactSearch = true;
                        // Hide regular elements, show compact ones
                        document.querySelectorAll('.label-element, .input-field').forEach(el => {
                            el.style.opacity = '0';
                            el.style.height = '0';
                        });
                        document.querySelectorAll('.compact-text').forEach(el => {
                            el.style.display = 'block';
                            setTimeout(() => {
                                el.style.opacity = '1';
                            }, 50);
                        });
                        if (searchbox) {
                            searchbox.classList.add('compact-searchbox');
                        }
                    } else if (scrollY <= 50 && this.isCompactSearch) {
                        this.isCompactSearch = false;
                        // Show regular elements, hide compact ones
                        document.querySelectorAll('.label-element, .input-field').forEach(el => {
                            el.style.opacity = '1';
                            el.style.height = 'auto';
                        });
                        document.querySelectorAll('.compact-text').forEach(el => {
                            el.style.opacity = '0';
                            setTimeout(() => {
                                el.style.display = 'none';
                            }, 300);
                        });
                        if (searchbox) {
                            searchbox.classList.remove('compact-searchbox');
                        }
                    }
                }
            }));

            // Create motion directive
            Alpine.directive('motion', (el, { value, modifiers, expression }, { evaluateLater, effect }) => {
                let evaluate = evaluateLater(expression);

                effect(() => {
                    evaluate(result => {
                        if (window.framerMotion) {
                            const { animate } = window.framerMotion;

                            // Default animation
                            let animation = { opacity: [0, 1], y: [20, 0] };
                            let options = { duration: 0.5, ease: 'easeOut' };

                            // Handle different animation types via modifiers
                            if (modifiers.includes('fade')) {
                                animation = { opacity: [0, 1] };
                            } else if (modifiers.includes('slide')) {
                                animation = { x: [-20, 0], opacity: [0, 1] };
                            } else if (modifiers.includes('scale')) {
                                animation = { scale: [0.9, 1], opacity: [0, 1] };
                            } else if (modifiers.includes('reveal')) {
                                animation = {
                                    clipPath: ['inset(0 0 100% 0)', 'inset(0 0 0% 0)'],
                                    y: [20, 0]
                                };
                            }

                            // Apply animation
                            animate(el, animation, options);
                        }
                    });
                });
            });
        });

        // Initialize staggered animations for page elements
        document.addEventListener('DOMContentLoaded', () => {
            if (typeof window.framerMotion !== 'undefined') {
                const { animate, stagger } = window.framerMotion;
                console.log('Framer Motion loaded successfully');

                // Staggered animation for main content sections
                const contentSections = document.querySelectorAll('.motion-section');
                if (contentSections.length > 0) {
                    animate(contentSections,
                        { opacity: [0, 1], y: [20, 0] },
                        { delay: stagger(0.1), duration: 0.5, ease: "easeOut" }
                    );
                }

                // Page transition effect
                const mainContent = document.querySelector('main');
                if (mainContent) {
                    animate(mainContent,
                        { opacity: [0, 1] },
                        { duration: 0.4, ease: "easeOut" }
                    );
                }

                // Navbar animation
                const navbar = document.querySelector('nav');
                if (navbar) {
                    animate(navbar,
                        { y: [-10, 0], opacity: [0, 1] },
                        { duration: 0.5, ease: "easeOut" }
                    );
                }

                // Setup scroll animations
                const scrollElements = document.querySelectorAll('[data-scroll-animate]');
                if (scrollElements.length > 0) {
                    const observer = new IntersectionObserver((entries) => {
                        entries.forEach(entry => {
                            if (entry.isIntersecting) {
                                const el = entry.target;
                                const animationType = el.dataset.scrollAnimate || 'fade';

                                let animation = { opacity: [0, 1] };
                                if (animationType === 'slide-up') {
                                    animation = { opacity: [0, 1], y: [50, 0] };
                                } else if (animationType === 'slide-in') {
                                    animation = { opacity: [0, 1], x: [-50, 0] };
                                } else if (animationType === 'scale') {
                                    animation = { opacity: [0, 1], scale: [0.8, 1] };
                                }

                                animate(el, animation, {
                                    duration: 0.7,
                                    ease: "easeOut"
                                });

                                observer.unobserve(el);
                            }
                        });
                    }, { threshold: 0.1 });

                    scrollElements.forEach(el => observer.observe(el));
                }
            }
        });
    </script>
    <script>
        // Get user location from browser
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function (position) {
                // Set cookies with user location
                document.cookie = "user_latitude=" + position.coords.latitude + "; path=/";
                document.cookie = "user_longitude=" + position.coords.longitude + "; path=/";

                // Reload the page to update distances
                if (!document.cookie.includes('user_latitude')) {
                    window.location.reload();
                }
            }, function (error) {
                console.error("Error getting location: ", error.message);
            });
        }
    </script>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link
        href="{{ asset('css/infinite-scroll.css') }}"
        rel="stylesheet"
    >
    @stack('styles')
    <!-- Livewire Styles -->
    @livewireStyles
    
    <!-- Custom styles for preventing layout shifts -->
    <style>
        /* Filter pill styling */
        .filter-pill {
            @apply bg-gray-100 border border-gray-200 rounded-full px-4 py-2 text-sm whitespace-nowrap cursor-pointer transition-all duration-200;
        }
    
        .filter-pill:hover {
            @apply bg-gray-200;
        }
    
        /* Hide scrollbar but allow scrolling */
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }
    
        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    
        /* Ensure images load smoothly */
        img {
            opacity: 1;
            transition: opacity 0.3s ease;
        }
    
        img[loading] {
            opacity: 0;
        }
        
        /* Skeleton loader styles */
        .skeleton-loader {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: skeleton-loading 1.5s infinite;
        }
        
        @keyframes skeleton-loading {
            0% {
                background-position: 200% 0;
            }
            100% {
                background-position: -200% 0;
            }
        }
    
        /* Prevent content jumping */
        .min-h-card {
            min-height: 350px;
        }
    
        /* Prevent layout shifts with smooth transitions */
        .sacred-places-grid {
            transition: height 0.3s ease-out;
        }
    
        /* Hide scrollbar but allow scrolling */
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }
    
        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    
        /* Ensure images load smoothly */
        img {
            transition: opacity 0.3s ease;
            opacity: 0;
        }
    
        img.loaded,
        img[src] {
            opacity: 1;
        }
    
        /* Loading indicator */
        #loading-more-indicator {
            transition: opacity 0.3s ease;
        }
    
        #loading-more-indicator.loading {
            opacity: 1;
        }
    
        /* Filter pill styling */
        .filter-pill {
            background-color: #f7f7f7;
            border: 1px solid #EBEBEB;
            border-radius: 30px;
            padding: 8px 16px;
            font-size: 14px;
            white-space: nowrap;
            cursor: pointer;
            transition: all 0.2s;
        }
    
        .filter-pill:hover {
            background-color: #DDDDDD;
        }
    
        /* Hide skeleton loaders - more aggressive approach */
        [wire\:loading],
        [wire\:loading\.delay],
        div[wire\:loading],
        div[wire\:loading\.delay],
        *[wire\:loading],
        *[wire\:loading\.delay],
        .animate-pulse,
        [class*="animate-pulse"],
        div.animate-pulse,
        *[class*="animate-pulse"] {
            display: none !important;
            visibility: hidden !important;
            opacity: 0 !important;
            pointer-events: none !important;
            position: absolute !important;
            left: -9999px !important;
            top: -9999px !important;
            height: 0 !important;
            width: 0 !important;
            overflow: hidden !important;
            z-index: -9999 !important;
        }
    </style>
</head>

<body
    class="bg-gray-100 text-gray-900 flex flex-col min-h-screen font-['Noto_Sans_Thai']"
    x-data="pageTransition"
    @scroll.window="handleScroll"
    x-bind:class="{ 'opacity-0': !show }"
    x-transition.duration.500ms
>
    <div class="page-wrapper flex flex-col min-h-screen">
        @include('components.navbar')

        <main class="flex-grow motion-section">
            @yield('content')
        </main>

        @include('components.footer')

    </div>
    
    <!-- Animation helper classes -->
    <style>
        /* Base transition class */
        .transition-all {
            transition-property: all;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 300ms;
        }
    
        /* For elements with scroll animations */
        [data-scroll-animate] {
            opacity: 0;
        }
    
        /* Motion helper classes */
        .motion-section {
            will-change: transform, opacity;
        }
    
        /* Animation preset classes */
        .appear-up {
            transform: translateY(20px);
            opacity: 0;
        }
    
        .appear-left {
            transform: translateX(-20px);
            opacity: 0;
        }
    
        .appear-right {
            transform: translateX(20px);
            opacity: 0;
        }
    
        .appear-scale {
            transform: scale(0.9);
            opacity: 0;
        }
        
        /* Searchbox transition styles */
        .compact-text {
            display: none;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        .label-element, .input-field {
            transition: opacity 0.3s ease, height 0.3s ease;
        }
        
        .compact-searchbox {
            transform: scale(0.85);
            padding: 0.5rem !important;
            transition: all 0.3s ease;
        }
    </style>
    
    <!-- Livewire Scripts -->
    @livewireScripts
    
    <!-- Script to handle image loading smoothly -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Remove all skeleton loaders immediately
            removeSkeletonLoaders();

            // Handle image loading
            handleImages();

            // Listen for Livewire events
            document.addEventListener('livewire:initialized', () => {
                // Handle when new items are loaded
                Livewire.on('items-loaded', () => {
                    console.log('Items loaded, refreshing images');
                    setTimeout(() => {
                        removeSkeletonLoaders();
                        handleImages();
                    }, 100);
                });

                // Handle when loading state changes
                Livewire.on('setLoadingMoreFalse', () => {
                    console.log('Setting loadingMore to false');
                    setTimeout(() => {
                        removeSkeletonLoaders();
                    }, 100);
                });
            });

            function handleImages() {
                // Find all lazy-loaded images
                const images = document.querySelectorAll('img[loading="lazy"]');

                images.forEach(img => {
                    // If image is already loaded
                    if (img.complete) {
                        img.style.opacity = '1';
                        // Hide the skeleton loader
                        const skeletonLoader = img.previousElementSibling;
                        if (skeletonLoader && skeletonLoader.classList.contains('skeleton-loader')) {
                            skeletonLoader.classList.add('hidden');
                        }
                    } else {
                        // Add loaded class when image loads
                        img.addEventListener('load', function () {
                            img.style.opacity = '1';
                            // Hide the skeleton loader
                            const skeletonLoader = img.previousElementSibling;
                            if (skeletonLoader && skeletonLoader.classList.contains('skeleton-loader')) {
                                skeletonLoader.classList.add('hidden');
                            }
                        });

                        // Handle error case
                        img.addEventListener('error', function () {
                            if (img.src !== '/images/placeholder.png') {
                                img.src = '/images/placeholder.png';
                            }
                            img.style.opacity = '1';
                            // Hide the skeleton loader
                            const skeletonLoader = img.previousElementSibling;
                            if (skeletonLoader && skeletonLoader.classList.contains('skeleton-loader')) {
                                skeletonLoader.classList.add('hidden');
                            }
                        });
                    }
                });

                // Remove any skeleton loaders
                removeSkeletonLoaders();
            }

            function removeSkeletonLoaders() {
                // Remove any skeleton loaders that might be visible
                const skeletonSelectors = [
                    '[wire\\:loading]',
                    '[wire\\:loading\\.delay]',
                    '.animate-pulse',
                    '[class*="animate-pulse"]'
                ];

                skeletonSelectors.forEach(selector => {
                    document.querySelectorAll(selector).forEach(el => {
                        el.style.display = 'none';
                        el.style.visibility = 'hidden';
                        el.style.opacity = '0';
                        el.style.pointerEvents = 'none';
                        el.style.position = 'absolute';
                        el.style.left = '-9999px';
                        el.style.height = '0';
                        el.style.width = '0';
                        el.style.overflow = 'hidden';

                        // Remove the element from the DOM
                        if (el.parentNode) {
                            el.parentNode.removeChild(el);
                        }
                    });
                });

                // Make sure content is visible
                document.querySelectorAll('[wire\\:loading\\.remove]').forEach(el => {
                    el.style.display = 'block';
                    el.style.visibility = 'visible';
                    el.style.opacity = '1';
                });
            }

            // Force remove skeleton loaders every 500ms
            setInterval(function () {
                removeSkeletonLoaders();

                // Check if we need to load more items
                const loadingIndicator = document.getElementById('loading-indicator');
                if (loadingIndicator) {
                    const rect = loadingIndicator.getBoundingClientRect();
                    const isVisible = (
                        rect.top >= 0 &&
                        rect.left >= 0 &&
                        rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
                        rect.right <= (window.innerWidth || document.documentElement.clientWidth)
                    );

                    if (isVisible) {
                        console.log('Loading indicator is visible, checking if we need to load more items');
                        // Check if we need to load more items
                        if (window.Livewire) {
                            const component = window.Livewire.find(
                                document.querySelector('[wire\\:id]').getAttribute('wire:id')
                            );

                            if (component && !component.loadingMore && component.hasMorePages) {
                                console.log('Loading more items from interval check');
                                component.loadMore();
                            }
                        }
                    }
                }
            }, 500);
        });
    </script>
    @stack('scripts')
</body>

</html>