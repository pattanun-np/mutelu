<?php

namespace App\Http\Controllers;

use App\Models\Sacredplace;
use App\Models\Tag;
use App\Services\SupabaseStorageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SacredplaceController extends Controller
{
    protected $supabaseStorage;

    public function __construct(SupabaseStorageService $supabaseStorage)
    {
        $this->supabaseStorage = $supabaseStorage;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        if ($search) {
            // If search is provided, show search results view
            return view('sacredplaces.index', [
                'search' => $search
            ]);
        }

        // Default home view
        return view('home');
    }

    /**
     * API endpoint for infinite scroll
     */
    public function apiIndex(Request $request)
    {
        $perPage = $request->input('per_page', 12);
        $page = $request->input('page', 1);
        $search = $request->input('search');

        $query = Sacredplace::select('id', 'name', 'description', 'image', 'latitude', 'longitude', 'created_at')
            ->distinct('id');

        // Apply search filter if provided
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    // Search in tags using the tag_ids JSON column
                    ->orWhereHas('tags', function ($tagQuery) use ($search) {
                        $tagQuery->where('name', 'like', "%{$search}%");
                    });
            });
        }

        $sacredplaces = $query->orderBy('created_at', 'desc')
            ->paginate($perPage);

        return response()->json([
            'data' => $sacredplaces->items(),
            'next_page_url' => $sacredplaces->nextPageUrl(),
            'has_more' => $sacredplaces->hasMorePages()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tags = Tag::all();
        return view('sacredplaces.create', compact('tags'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'tags' => 'array',
        ]);

        // Handle image upload to Supabase
        $imageUrl = $this->supabaseStorage->upload($request->file('image'), 'sacredplaces');

        if (!$imageUrl) {
            return back()->withErrors(['image' => 'Failed to upload image to Supabase.'])->withInput();
        }

        // Create the sacred place
        $sacredplace = Sacredplace::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'image' => $imageUrl,
            'latitude' => $validated['latitude'],
            'longitude' => $validated['longitude'],
        ]);

        // Attach tags if any
        if ($request->has('tags')) {
            $sacredplace->tags()->attach($request->tags);
        }

        return redirect()->route('sacredplaces.show', $sacredplace)
            ->with('success', 'Sacred place created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Sacredplace $sacredplace)
    {
        return view('sacredplaces.show', compact('sacredplace'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sacredplace $sacredplace)
    {
        $tags = Tag::all();
        $selectedTags = $sacredplace->tags->pluck('id')->toArray();

        return view('sacredplaces.edit', compact('sacredplace', 'tags', 'selectedTags'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sacredplace $sacredplace)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'tags' => 'array',
        ]);

        // Update sacred place data
        $sacredplace->name = $validated['name'];
        $sacredplace->description = $validated['description'];
        $sacredplace->latitude = $validated['latitude'];
        $sacredplace->longitude = $validated['longitude'];

        // Handle image update if a new one is provided
        if ($request->hasFile('image')) {
            // Delete old image from Supabase if it exists
            if ($sacredplace->image) {
                $this->supabaseStorage->delete($sacredplace->image);
            }

            // Upload new image to Supabase
            $imageUrl = $this->supabaseStorage->upload($request->file('image'), 'sacredplaces');

            if (!$imageUrl) {
                return back()->withErrors(['image' => 'Failed to upload image to Supabase.'])->withInput();
            }

            $sacredplace->image = $imageUrl;
        }

        $sacredplace->save();

        // Sync tags
        if ($request->has('tags')) {
            $sacredplace->tags()->sync($request->tags);
        } else {
            $sacredplace->tags()->detach();
        }

        return redirect()->route('sacredplaces.show', $sacredplace)
            ->with('success', 'Sacred place updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sacredplace $sacredplace)
    {
        // Delete the image from Supabase if it exists
        if ($sacredplace->image) {
            $this->supabaseStorage->delete($sacredplace->image);
        }

        // Delete the sacred place (will cascade to related records)
        $sacredplace->delete();

        return redirect()->route('home')
            ->with('success', 'Sacred place deleted successfully.');
    }
}
