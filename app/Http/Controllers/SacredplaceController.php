<?php

namespace App\Http\Controllers;

use App\Models\Sacredplace;
use App\Models\Tag;
use Illuminate\Http\Request;

class SacredplaceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('home');
    }

    /**
     * API endpoint for infinite scroll
     */
    public function apiIndex(Request $request)
    {
        $perPage = $request->input('per_page', 12);
        $page = $request->input('page', 1);

        $sacredplaces = Sacredplace::select('id', 'name', 'description', 'image', 'latitude', 'longitude', 'created_at')
            ->distinct('id')
            ->orderBy('created_at', 'desc')
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
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sacredplace $sacredplace)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sacredplace $sacredplace)
    {
        //
    }
}
