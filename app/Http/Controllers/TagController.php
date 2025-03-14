<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tags = Tag::orderBy('name')->get();
        return view('tags.index', compact('tags'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Check if user is authenticated
        if (!session()->has('user_id')) {
            session()->put('url.intended', url()->current());
            return redirect()->route('login')->with('error', 'You must be logged in to create a tag.');
        }

        return view('tags.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Check if user is authenticated
        if (!session()->has('user_id')) {
            return redirect()->route('login')->with('error', 'You must be logged in to create a tag.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:tags',
            'description' => 'nullable|string',
        ]);

        $tag = Tag::create($validated);

        return redirect()->route('tags.index')
            ->with('success', 'Tag created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Tag $tag)
    {
        $sacredplaces = $tag->sacredplaces();
        return view('tags.show', compact('tag', 'sacredplaces'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tag $tag)
    {
        // Check if user is authenticated
        if (!session()->has('user_id')) {
            session()->put('url.intended', url()->current());
            return redirect()->route('login')->with('error', 'You must be logged in to edit a tag.');
        }

        return view('tags.edit', compact('tag'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tag $tag)
    {
        // Check if user is authenticated
        if (!session()->has('user_id')) {
            return redirect()->route('login')->with('error', 'You must be logged in to update a tag.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:tags,name,' . $tag->id,
            'description' => 'nullable|string',
        ]);

        $tag->update($validated);

        return redirect()->route('tags.index')
            ->with('success', 'Tag updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tag $tag)
    {
        // Check if user is authenticated
        if (!session()->has('user_id')) {
            return redirect()->route('login')->with('error', 'You must be logged in to delete a tag.');
        }

        // Get all sacred places that use this tag
        $sacredplaces = $tag->sacredplaces();

        // Remove this tag from all sacred places
        foreach ($sacredplaces as $sacredplace) {
            $tagIds = $sacredplace->tag_ids ?? [];
            $tagIds = array_filter($tagIds, function ($id) use ($tag) {
                return $id != $tag->id;
            });
            $sacredplace->syncTags($tagIds);
        }

        // Delete the tag
        $tag->delete();

        return redirect()->route('tags.index')
            ->with('success', 'Tag deleted successfully.');
    }
}
