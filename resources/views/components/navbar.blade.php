<nav class="bg-white sticky top-0 z-50 h-full">
    <div class="container mx-auto flex justify-between items-center flex-col">
        <!-- Searchbox -->
        <div class="flex flex-col space-y-2">
            <div class="flex items-center justify-between w-full p-2">
                <h1 class="text-2xl font-extrabold text-start">
                    <span class="text-rose-500">MU</span>|Directory
                </h1>
                @include('components.searchbox')
            </div>


        </div>

        {{-- @auth

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
</nav>