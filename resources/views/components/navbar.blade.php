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
                    class="text-gray-700 hover:text-rose-600 font-medium"
                >
                    Add Place
                </a>
                <a
                    href="{{ route('tags.index') }}"
                    class="text-gray-700 hover:text-rose-600 font-medium"
                >
                    Tags
                </a>
                
                @if(session()->has('user_id'))
                    <!-- User is logged in -->
                    <div
                        class="relative"
                        x-data="{ open: false }"
                    >
                        <button
                            @click="open = !open"
                            class="flex items-center text-gray-700 hover:text-rose-600 font-medium"
                        >
                            <span>{{ session('user_name') }}</span>
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5 ml-1"
                                viewBox="0 0 20 20"
                                fill="currentColor"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd"
                                />
                            </svg>
                        </button>

                        <div
                            x-show="open"
                            @click.away="open = false"
                            class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 z-10"
                            x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="transform opacity-100 scale-100"
                            x-transition:leave-end="transform opacity-0 scale-95"
                        >
                            <form
                                action="{{ route('logout') }}"
                                method="POST"
                            >
                                @csrf
                                <button
                                    type="submit"
                                    class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                >
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Direct logout link for users having issues with dropdown -->
                    <form
                        action="{{ route('logout') }}"
                        method="POST"
                        class="inline"
                    >
                        @csrf
                        <button
                            type="submit"
                            class="text-gray-700 hover:text-rose-600 font-medium"
                        >
                            Logout
                        </button>
                    </form>
                @else
                    <!-- User is not logged in -->
                    <a
                        href="{{ route('login') }}"
                        class="text-gray-700 hover:text-rose-600 font-medium"
                    >
                        Login
                    </a>
                    <a
                        href="{{ route('register') }}"
                        class="bg-rose-600 hover:bg-rose-700 text-white font-medium py-2 px-4 rounded-lg shadow-sm transition-colors"
                    >
                        Register
                    </a>
                @endif
            </div>
        </div>
    </div>
</nav>