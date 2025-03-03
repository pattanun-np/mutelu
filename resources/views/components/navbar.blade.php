<nav class="bg-white sticky top-0 z-50 h-20">
    <div class="container mx-auto flex justify-between items-center">
       


            <!-- Searchbox -->
            @include('components.searchbox')

            
            {{-- @auth
                <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-blue-500 text-white rounded-md">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="px-4 py-2 border rounded-md">Login</a>
                <a href="{{ route('register') }}" class="px-4 py-2 bg-blue-500 text-white rounded-md">Sign Up</a>
            @endauth --}}
        
    </div>
</nav>
