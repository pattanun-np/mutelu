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
    
    @stack('scripts')
</body>

</html>