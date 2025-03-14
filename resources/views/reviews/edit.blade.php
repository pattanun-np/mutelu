@extends('layouts.app')

@section('content')
<style>
    /* Fallback styling for star rating */
    @for ($i = 1; $i <= 5; $i++)
        @if ($i <= $review->rating)
            #rating-{{ $i }} + label {
                color: #facc15 !important; /* yellow-400 */
            }
        @endif
    @endfor
</style>

<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <div class="flex items-center mb-6">
            <a href="{{ route('sacredplaces.show', $sacredplace) }}" class="text-rose-600 hover:text-rose-800 mr-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
            </a>
            <h1 class="text-3xl font-bold text-gray-800">Edit Your Review for {{ $sacredplace->name }}</h1>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-6">
            <form action="{{ route('reviews.update', $review) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                    <input 
                        type="text" 
                        name="title" 
                        id="title" 
                        value="{{ old('title', $review->title) }}" 
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-rose-500 focus:ring focus:ring-rose-200 focus:ring-opacity-50 @error('title') border-red-500 @enderror" 
                        required
                    >
                    @error('title')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="body" class="block text-sm font-medium text-gray-700 mb-1">Review</label>
                    <textarea 
                        name="body" 
                        id="body" 
                        rows="6" 
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-rose-500 focus:ring focus:ring-rose-200 focus:ring-opacity-50 @error('body') border-red-500 @enderror" 
                        required
                    >{{ old('body', $review->body) }}</textarea>
                    @error('body')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Rating</label>
                    <div class="flex items-center space-x-2">
                        @for ($i = 1; $i <= 5; $i++)
                            <div class="flex items-center">
                                <input 
                                    type="radio" 
                                    name="rating" 
                                    id="rating-{{ $i }}" 
                                    value="{{ $i }}" 
                                    class="hidden peer" 
                                    {{ $review->rating == $i ? 'checked' : '' }}
                                    required
                                >
                                <label 
                                    for="rating-{{ $i }}" 
                                    class="cursor-pointer text-3xl px-1 py-1 text-gray-300 peer-checked:text-yellow-400 hover:text-yellow-400"
                                    data-rating="{{ $i }}"
                                >★</label>
                            </div>
                        @endfor
                    </div>
                    @error('rating')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-between">
                    <form 
                        action="{{ route('reviews.destroy', $review) }}" 
                        method="POST" 
                        class="inline" 
                        onsubmit="return confirm('Are you sure you want to delete this review?');"
                    >
                        @csrf
                        @method('DELETE')
                        <button 
                            type="submit" 
                            class="bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-lg shadow-sm transition-colors"
                        >
                            Delete Review
                        </button>
                    </form>
                    
                    <div>
                        <a 
                            href="{{ route('sacredplaces.show', $sacredplace) }}" 
                            class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium py-2 px-4 rounded-lg shadow-sm transition-colors mr-2"
                        >
                            Cancel
                        </a>
                        <button 
                            type="submit" 
                            class="bg-rose-600 hover:bg-rose-700 text-white font-medium py-2 px-4 rounded-lg shadow-sm transition-colors"
                        >
                            Update Review
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // JavaScript to enhance the star rating UI
    document.addEventListener('DOMContentLoaded', function() {
        const stars = document.querySelectorAll('input[name="rating"] + label');
        const radioInputs = document.querySelectorAll('input[name="rating"]');
        
        // Debug: Log the current rating value
        console.log('Current review rating:', {{ $review->rating }});
        
        // Ensure the correct radio button is checked based on the review rating
        const currentRating = {{ $review->rating }};
        radioInputs.forEach((input, index) => {
            if (parseInt(input.value) === currentRating) {
                input.checked = true;
                console.log('Setting radio button', index + 1, 'as checked');
            }
        });
        
        // Add transition effect to all stars
        stars.forEach(star => {
            star.style.transition = 'all 0.2s ease';
        });
        
        // Function to update star appearance
        function updateStars() {
            radioInputs.forEach((input, i) => {
                if (input.checked) {
                    console.log('Radio button', i + 1, 'is checked');
                    // Highlight current star and all previous stars
                    for (let j = 0; j <= i; j++) {
                        stars[j].classList.add('text-yellow-400');
                        stars[j].classList.remove('text-gray-300');
                        // Add a subtle transform effect to show it's selected
                        stars[j].style.transform = 'scale(1.1)';
                        stars[j].style.textShadow = '0 0 5px rgba(250, 204, 21, 0.5)';
                    }
                    // Remove highlight from all next stars
                    for (let j = i + 1; j < stars.length; j++) {
                        stars[j].classList.remove('text-yellow-400');
                        stars[j].classList.add('text-gray-300');
                        // Reset transform
                        stars[j].style.transform = 'scale(1)';
                        stars[j].style.textShadow = 'none';
                    }
                }
            });
        }
        
        // Initialize stars based on current selection
        updateStars();
        
        // Add direct click handlers to the labels
        document.querySelectorAll('label[data-rating]').forEach(label => {
            label.addEventListener('click', function() {
                const rating = parseInt(this.getAttribute('data-rating'));
                console.log('Star clicked with rating:', rating);
                
                // Set the corresponding radio button as checked
                document.getElementById('rating-' + rating).checked = true;
                
                // Update the stars
                updateStars();
            });
        });
        
        stars.forEach((star, index) => {
            // Add click event to ensure the radio button is selected
            star.addEventListener('click', () => {
                radioInputs[index].checked = true;
                updateStars();
            });
            
            star.addEventListener('mouseover', () => {
                // Highlight current star and all previous stars
                for (let i = 0; i <= index; i++) {
                    stars[i].classList.add('text-yellow-400');
                    stars[i].classList.remove('text-gray-300');
                    // Add hover effect
                    stars[i].style.transform = 'scale(1.1)';
                }
                // Remove highlight from all next stars
                for (let i = index + 1; i < stars.length; i++) {
                    stars[i].classList.remove('text-yellow-400');
                    stars[i].classList.add('text-gray-300');
                    // Reset transform
                    stars[i].style.transform = 'scale(1)';
                }
            });
            
            star.addEventListener('mouseout', () => {
                // Reset all stars based on selection
                updateStars();
            });
        });
    });
</script>
@endsection 