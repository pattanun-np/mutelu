@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-3xl mx-auto bg-white rounded-lg shadow-md p-6">
            <h1 class="text-2xl font-bold mb-6">Edit Sacred Place: {{ $sacredplace->name }}</h1>

            <form
                action="{{ route('sacredplaces.update', $sacredplace) }}"
                method="POST"
                enctype="multipart/form-data"
            >
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label
                        for="name"
                        class="block text-gray-700 font-medium mb-2"
                    >Name</label>
                    <input
                        type="text"
                        name="name"
                        id="name"
                        value="{{ old('name', $sacredplace->name) }}"
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
                    >{{ old('description', $sacredplace->description) }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label
                        for="image"
                        class="block text-gray-700 font-medium mb-2"
                    >Image</label>
                    <div class="mb-2">
                        <img
                            src="{{ $sacredplace->image }}"
                            alt="{{ $sacredplace->name }}"
                            class="w-32 h-32 object-cover rounded"
                        >
                    </div>
                    <input
                        type="file"
                        name="image"
                        id="image"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >
                    <p class="text-sm text-gray-600 mt-1">Leave empty to keep the current image</p>
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
                            value="{{ old('latitude', $sacredplace->latitude) }}"
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
                            value="{{ old('longitude', $sacredplace->longitude) }}"
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
                                    {{ in_array($tag->id, old('tags', $selectedTags)) ? 'checked' : '' }}
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
                        href="{{ route('sacredplaces.show', $sacredplace) }}"
                        class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400"
                    >
                        Cancel
                    </a>
                    <button
                        type="submit"
                        class="px-4 py-2 bg-rose-500 text-white rounded-lg hover:bg-rose-600"
                    >
                        Update Sacred Place
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection