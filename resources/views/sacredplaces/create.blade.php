@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-3xl mx-auto bg-white rounded-lg shadow-md p-6">
            <h1 class="text-2xl font-bold mb-6">Add New Sacred Place</h1>

            <form
                action="{{ route('sacredplaces.store') }}"
                method="POST"
                enctype="multipart/form-data"
            >
                @csrf

                <div class="mb-4">
                    <label
                        for="name"
                        class="block text-gray-700 font-medium mb-2"
                    >Name</label>
                    <input
                        type="text"
                        name="name"
                        id="name"
                        value="{{ old('name') }}"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required
                    >
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label
                        for="description"
                        class="block text-gray-700 font-medium mb-2"
                    >Description</label>
                    <textarea
                        name="description"
                        id="description"
                        rows="4"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required
                    >{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label
                        for="image"
                        class="block text-gray-700 font-medium mb-2"
                    >Image</label>

                    <div 
                        id="drop-area" 
                        class="w-full border-2 border-dashed border-gray-300 rounded-lg p-6 text-center cursor-pointer hover:border-blue-500 transition-colors"
                    >
                        <div id="preview-container" class="hidden mb-4">
                            <img id="image-preview" class="max-h-48 mx-auto rounded" alt="Image preview">
                        </div>
                        <div id="upload-prompt">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                            </svg>
                            <p class="mt-2 text-gray-600">Drag and drop your image here or</p>
                            <button type="button" id="browse-button" class="mt-2 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                                Browse Files
                            </button>
                            <p class="mt-1 text-sm text-gray-500">Supported formats: JPG, PNG, GIF</p>
                        </div>
                        <input
                            type="file"
                            name="image"
                            id="image"
                            class="hidden"
                            accept="image/*"
                            required
                        >
                    </div>
                    @error('image')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label
                            for="latitude"
                            class="block text-gray-700 font-medium mb-2"
                        >Latitude</label>
                        <input
                            type="number"
                            step="any"
                            name="latitude"
                            id="latitude"
                            value="{{ old('latitude') }}"
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required
                        >
                        @error('latitude')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label
                            for="longitude"
                            class="block text-gray-700 font-medium mb-2"
                        >Longitude</label>
                        <input
                            type="number"
                            step="any"
                            name="longitude"
                            id="longitude"
                            value="{{ old('longitude') }}"
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required
                        >
                        @error('longitude')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 font-medium mb-2">Tags</label>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
                        @foreach($tags as $tag)
                            <div class="flex items-center">
                                <input
                                    type="checkbox"
                                    name="tags[]"
                                    id="tag-{{ $tag->id }}"
                                    value="{{ $tag->id }}"
                                    class="mr-2"
                                    {{ in_array($tag->id, old('tags', [])) ? 'checked' : '' }}
                                >
                                <label for="tag-{{ $tag->id }}">{{ $tag->name }}</label>
                            </div>
                        @endforeach
                    </div>
                    @error('tags')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-between">
                    <a
                        href="{{ route('home') }}"
                        class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400"
                    >
                        Cancel
                    </a>
                    <button
                        type="submit"
                        class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600"
                    >
                        Create Sacred Place
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const dropArea = document.getElementById('drop-area');
            const fileInput = document.getElementById('image');
            const browseButton = document.getElementById('browse-button');
            const previewContainer = document.getElementById('preview-container');
            const imagePreview = document.getElementById('image-preview');
            const uploadPrompt = document.getElementById('upload-prompt');

            // Configuration
            const maxFileSize = 5 * 1024 * 1024; // 5MB
            const allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];

            // Open file dialog when browse button is clicked
            browseButton.addEventListener('click', function(e) {
                e.preventDefault();
                fileInput.click();
            });

            // Handle click on the drop area
            dropArea.addEventListener('click', function(e) {
                if (e.target === dropArea || e.target.closest('#drop-area') && !e.target.closest('button')) {
                    fileInput.click();
                }
            });

            // Prevent default drag behaviors
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                dropArea.addEventListener(eventName, preventDefaults, false);
                document.body.addEventListener(eventName, preventDefaults, false);
            });

            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }

            // Highlight drop area when item is dragged over it
            ['dragenter', 'dragover'].forEach(eventName => {
                dropArea.addEventListener(eventName, highlight, false);
            });

            ['dragleave', 'drop'].forEach(eventName => {
                dropArea.addEventListener(eventName, unhighlight, false);
            });

            function highlight() {
                dropArea.classList.add('border-blue-500', 'bg-blue-50');
                dropArea.classList.add('animate-pulse');
            }

            function unhighlight() {
                dropArea.classList.remove('border-blue-500', 'bg-blue-50');
                dropArea.classList.remove('animate-pulse');
            }

            // Handle dropped files
            dropArea.addEventListener('drop', handleDrop, false);

            function handleDrop(e) {
                const dt = e.dataTransfer;
                const files = dt.files;

                if (files.length) {
                    handleFiles(files);
                }
            }

            // Handle file input change
            fileInput.addEventListener('change', function() {
                if (this.files.length) {
                    handleFiles(this.files);
                }
            });

            // Process the files
            function handleFiles(files) {
                const file = files[0]; // We only need one file for this form

                // Validate file type
                if (!allowedTypes.includes(file.type)) {
                    showError(`Invalid file type. Please select a JPG, PNG, or GIF image.`);
                    return;
                }

                // Validate file size
                if (file.size > maxFileSize) {
                    showError(`File is too large. Maximum size is ${formatFileSize(maxFileSize)}.`);
                    return;
                }

                // Set the file to the input
                fileInput.files = files;
                updateFilePreview(file);
            }

            // Show error message
            function showError(message) {
                // Create error element
                const errorElement = document.createElement('div');
                errorElement.className = 'bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mt-2';
                errorElement.innerHTML = `
                    <span class="block sm:inline">${message}</span>
                    <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                        <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <title>Close</title>
                            <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/>
                        </svg>
                    </span>
                `;

                // Add error to the DOM
                dropArea.parentNode.insertBefore(errorElement, dropArea.nextSibling);

                // Remove error after 5 seconds
                setTimeout(() => {
                    errorElement.remove();
                }, 5000);

                // Add click handler to close button
                errorElement.querySelector('svg').addEventListener('click', () => {
                    errorElement.remove();
                });
            }

            // Format file size to human-readable format
            function formatFileSize(bytes) {
                if (bytes === 0) return '0 Bytes';
                const k = 1024;
                const sizes = ['Bytes', 'KB', 'MB', 'GB'];
                const i = Math.floor(Math.log(bytes) / Math.log(k));
                return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
            }

            // Update preview with selected file
            function updateFilePreview(file) {
                const reader = new FileReader();

                // Show loading state
                previewContainer.classList.remove('hidden');
                imagePreview.src = '';
                imagePreview.alt = 'Loading preview...';
                previewContainer.classList.add('opacity-50');

                reader.onload = function(e) {
                    // Remove loading state
                    previewContainer.classList.remove('opacity-50');

                    // Update preview image
                    imagePreview.src = e.target.result;
                    imagePreview.alt = file.name;

                    // Update file info
                    uploadPrompt.innerHTML = `
                        <div class="flex items-center justify-center mt-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            <span class="text-sm text-gray-600">${file.name} (${formatFileSize(file.size)})</span>
                        </div>
                        <button type="button" id="change-file" class="mt-2 px-3 py-1 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 transition-colors">
                            Change image
                        </button>
                    `;

                    // Add event listener to the new "Change file" button
                    document.getElementById('change-file').addEventListener('click', function(e) {
                        e.preventDefault();
                        fileInput.click();
                    });

                    // Add animation to show success
                    dropArea.classList.add('border-green-500');
                    setTimeout(() => {
                        dropArea.classList.remove('border-green-500');
                    }, 1500);
                }

                reader.onerror = function() {
                    showError('Error reading file. Please try again.');
                    previewContainer.classList.add('hidden');
                }

                reader.readAsDataURL(file);
            }

            // Initialize geolocation if latitude/longitude fields are empty
            const latitudeField = document.getElementById('latitude');
            const longitudeField = document.getElementById('longitude');

            if (latitudeField && longitudeField && 
                (!latitudeField.value || !longitudeField.value)) {

                // Add a geolocation button next to the fields
                const locationContainer = latitudeField.closest('div').parentNode;
                const geoButton = document.createElement('button');
                geoButton.type = 'button';
                geoButton.className = 'mt-2 px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 flex items-center justify-center w-full';
                geoButton.innerHTML = `
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                    </svg>
                    Use my current location
                `;

                locationContainer.insertBefore(geoButton, locationContainer.firstChild);

                // Add click handler for geolocation
                geoButton.addEventListener('click', function() {
                    if (navigator.geolocation) {
                        geoButton.disabled = true;
                        geoButton.innerHTML = `
                            <svg class="animate-spin h-5 w-5 mr-2 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Getting location...
                        `;

                        navigator.geolocation.getCurrentPosition(
                            function(position) {
                                latitudeField.value = position.coords.latitude;
                                longitudeField.value = position.coords.longitude;

                                geoButton.innerHTML = `
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                    Location detected
                                `;
                                geoButton.disabled = true;
                                geoButton.className = 'mt-2 px-4 py-2 bg-green-600 text-white rounded-lg flex items-center justify-center w-full cursor-default';
                            },
                            function(error) {
                                geoButton.disabled = false;
                                geoButton.innerHTML = `
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                                    </svg>
                                    Try again
                                `;

                                showError('Could not get your location: ' + error.message);
                            }
                        );
                    } else {
                        showError('Geolocation is not supported by your browser');
                    }
                });
            }
        });
    </script>
@endsection