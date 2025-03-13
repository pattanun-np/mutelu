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
                            <button
                                type="button"
                                id="browse-button"
                                class="mt-2 px-4 py-2 bg-rose-500 text-white rounded-lg hover:bg-rose-600"
                            >
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
                        class="px-4 py-2 bg-rose-500 text-white rounded-lg hover:bg-rose-600"
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

            // Open file dialog when browse button is clicked
            browseButton.addEventListener('click', function () {
                fileInput.click();
            });

            // Handle click on the drop area
            dropArea.addEventListener('click', function(e) {
                if (e.target === dropArea) {
                    fileInput.click();
                }
            });

            // Prevent default drag behaviors
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                dropArea.addEventListener(eventName, preventDefaults, false);
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
                dropArea.classList.add('border-blue-500', 'bg-rose-50');
            }

            function unhighlight() {
                dropArea.classList.remove('border-blue-500', 'bg-rose-50');
            }

            // Handle dropped files
            dropArea.addEventListener('drop', handleDrop, false);

            function handleDrop(e) {
                const dt = e.dataTransfer;
                const files = dt.files;

                if (files.length) {
                    fileInput.files = files;
                    updateFilePreview(files[0]);
                }
            }

            // Handle file input change
            fileInput.addEventListener('change', function() {
                if (this.files.length) {
                    updateFilePreview(this.files[0]);
                }
            });

            // Update preview with selected file
            function updateFilePreview(file) {
                if (!file.type.match('image.*')) {
                    alert('Please select an image file (JPG, PNG, GIF)');
                    return;
                }

                const reader = new FileReader();

                reader.onload = function (e) {
                    imagePreview.src = e.target.result;
                    previewContainer.classList.remove('hidden');
                    uploadPrompt.innerHTML = `
                        <p class="text-sm text-gray-600 mt-2">File: ${file.name}</p>
                        <button type="button" id="change-file" class="mt-2 text-blue-500 hover:text-blue-700">
                            Change file
                        </button>
                    `;

                    // Add event listener to the new "Change file" button
                    document.getElementById('change-file').addEventListener('click', function () {
                        fileInput.click();
                    });
                }

                reader.readAsDataURL(file);
            }
        });
    </script>
@endsection