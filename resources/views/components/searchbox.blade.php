<div
    class="container mx-auto px-6 py-8 flex justify-center items-center transition-all duration-500 ease-in-out sticky top-0 z-10"
    id="searchbox-container"
>

    <div
        class="bg-white rounded-full shadow-lg p-4 max-w-4xl mx-auto mb-8 transition-all duration-500 ease-in-out transform"
        id="searchbox"
    >
        <form
            method="GET"
            class="flex flex-col md:flex-row items-center gap-4"
        >
            <div class="flex flex-col justify-center items-start input-container">
                <label
                    for="location"
                    class="block text-sm font-semibold text-gray-700 mb-1 label-element"
                >Where</label>
                <input
                    type="text"
                    id="location"
                    name="location"
                    placeholder="Anywhere"
                    class="w-full px-4 py-2 border-0 focus:ring-0 rounded-full input-field"
                >
                <span class="hidden compact-text text-sm font-medium">Anywhere</span>
            </div>


            <div class="flex flex-col space-y-1 justify-center items-start input-container">
                <label
                    for="check_in"
                    class="block text-sm font-semibold text-gray-700 mb-1 label-element"
                >Check in</label>
                <input
                    type="date"
                    id="check_in"
                    name="check_in"
                    class="w-full px-4 py-2 border-0 focus:ring-0 rounded-full input-field"
                >
                <span class="hidden compact-text text-sm font-medium">Anytime</span>
            </div>


            <div class="flex flex-col space-y-1 justify-center items-start input-container">
                <label
                    for="check_out"
                    class="block text-sm font-semibold text-gray-700 mb-1 label-element"
                >Check out</label>
                <input
                    type="date"
                    id="check_out"
                    name="check_out"
                    class="w-full px-4 py-2 border-0 focus:ring-0 rounded-full input-field"
                >
            </div>


            <div class="flex flex-col space-y-1 justify-center items-start input-container">
                <label
                    for="guests"
                    class="block text-sm font-semibold text-gray-700 mb-1 label-element"
                >Guests</label>
                <select
                    id="guests"
                    name="guests"
                    class="w-full px-4 py-2 border-0 focus:ring-0 rounded-full input-field"
                >
                    <option value="1">1 guest</option>
                    <option value="2">2 guests</option>
                    <option value="3">3 guests</option>
                    <option value="4">4 guests</option>
                    <option value="5">5+ guests</option>
                </select>
                <span class="hidden compact-text text-sm font-medium">Add guests</span>
            </div>

            <div class="mt-6">
                <button
                    type="submit"
                    class="bg-red-500 hover:bg-red-600 text-white px-6 py-3 rounded-full font-medium flex items-center"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5 mr-2"
                        viewBox="0 0 20 20"
                        fill="currentColor"
                    >
                        <path
                            fill-rule="evenodd"
                            d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                            clip-rule="evenodd"
                        />
                    </svg>
                    Search
                </button>
            </div>
        </form>
    </div>

    <!-- Life is available only in the present moment. - Thich Nhat Hanh -->
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchboxContainer = document.getElementById('searchbox-container');
        const searchbox = document.getElementById('searchbox');
        const labels = document.querySelectorAll('.label-element');
        const compactTexts = document.querySelectorAll('.compact-text');
        const inputFields = document.querySelectorAll('.input-field');
        let lastScrollTop = 0;
        let isVisible = true;

        window.addEventListener('scroll', function () {
            let scrollTop = window.pageYOffset || document.documentElement.scrollTop;

            // Determine scroll direction
            if (scrollTop > lastScrollTop && scrollTop > 50) {
                // Scrolling down - slink smaller
                if (isVisible) {
                    // Hide labels and show compact text
                    labels.forEach(label => {
                        label.style.display = 'none';
                    });

                    compactTexts.forEach(text => {
                        text.style.display = 'block';
                    });

                    // Hide input fields when slinking
                    inputFields.forEach(field => {
                        field.style.display = 'none';
                    });

                    // Make searchbox smaller
                    searchbox.style.transform = 'scale(0.85)';
                    searchbox.style.padding = '0.5rem';

                    // If continues scrolling down, hide completely
                    if (scrollTop > 200) {
                        searchbox.style.transform = 'translateY(-100%) scale(0.85)';
                        searchbox.style.opacity = '0';
                        setTimeout(() => {
                            if (scrollTop > lastScrollTop) { // Still scrolling down
                                searchboxContainer.style.visibility = 'hidden';
                            }
                        }, 500);
                        isVisible = false;
                    }
                }
            } else if (scrollTop < lastScrollTop || scrollTop <= 10) {
                // Scrolling up or at top - restore
                if (!isVisible) {
                    searchboxContainer.style.visibility = 'visible';
                    setTimeout(() => {
                        searchbox.style.transform = 'scale(0.85)';
                        searchbox.style.opacity = '1';
                    }, 50);
                    isVisible = true;
                }

                // If at top or continuing to scroll up, restore to full size
                if (scrollTop <= 50) {
                    // Show labels again and hide compact text
                    labels.forEach(label => {
                        label.style.display = 'block';
                    });

                    compactTexts.forEach(text => {
                        text.style.display = 'none';
                    });

                    // Show input fields again
                    inputFields.forEach(field => {
                        field.style.display = 'block';
                    });

                    // Restore searchbox size
                    searchbox.style.transform = 'scale(1)';
                    searchbox.style.padding = '1rem';
                }
            }

            lastScrollTop = scrollTop;
        });
    });
</script>

<style>
    #searchbox {
        transition: transform 0.3s ease, opacity 0.3s ease, padding 0.3s ease;
    }

    #searchbox-container {
        transition: visibility 0.3s ease;
    }

    .label-element {
        transition: display 0.3s ease;
    }

    .compact-text {
        transition: display 0.3s ease;
    }

    .input-field {
        transition: display 0.3s ease;
    }
</style>