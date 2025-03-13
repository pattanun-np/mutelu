<nav class="bg-white sticky top-0 z-50 shadow-sm">
    <div class="container mx-auto py-2">
        <div class="flex items-center justify-between">
            <!-- Logo -->
            <div class="flex items-center">
                <h1 class="text-2xl font-extrabold">
                    <a
                        href="{{ route('home') }}"
                        class="flex items-center"
                    >
                        <span class="text-rose-500">MU</span><span
                            class="text-gray-800">|Directory</span>
                    </a>
                </h1>
            </div>
            
            <!-- Search Box (only on home and search pages) -->
            @if(Route::is('home') || Route::is('sacredplaces.index'))
                <div class="flex-1 max-w-xl mx-4">
                    @include('components.search-box')
                </div>
            @endif
            
            <!-- Navigation Links -->
            <div class="flex items-center space-x-4">
                <a
                    href="{{ route('sacredplaces.create') }}"
                    class="text-gray-700 hover:text-blue-600 font-medium"
                >
                    Add Place
                </a>
                {{-- @auth
                    <!-- User dropdown would go here -->
                    @else
                    <a
                        href="{{ route('login') }}"
                        class="px-4 py-2 border rounded-md"
                    >Login</a>
                    <a
                        href="{{ route('register') }}"
                        class="px-4 py-2 bg-blue-500 text-white rounded-md"
                    >Sign Up</a>
                    @endauth --}}
            </div>
            </div>
    </div>
</nav>