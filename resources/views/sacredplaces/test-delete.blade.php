@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
            <h1 class="text-3xl font-bold mb-4">Test Delete Sacred Place</h1>

            <form
                action="{{ route('sacredplaces.destroy', 174) }}"
                method="POST"
                class="mt-4"
            >
                @csrf
                @method('DELETE')
                <button
                    type="submit"
                    class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600"
                >
                    Delete Sacred Place ID 174
                </button>
            </form>
        </div>
    </div>
@endsection