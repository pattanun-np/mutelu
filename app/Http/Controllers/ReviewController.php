<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Sacredplace;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Require authentication for all methods except index and show
        // Check if user is authenticated in each method
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Reviews are typically viewed in the context of a sacred place
        return redirect()->route('home');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        // Check if user is authenticated
        if (!session()->has('user_id')) {
            session()->put('url.intended', url()->current());
            return redirect()->route('login')->with('error', 'You must be logged in to write a review.');
        }

        // Get the sacred place ID from the request
        $sacredplaceId = $request->input('sacredplace_id');
        if (!$sacredplaceId) {
            return redirect()->route('home')->with('error', 'Sacred place not specified.');
        }

        $sacredplace = Sacredplace::findOrFail($sacredplaceId);

        return view('reviews.create', compact('sacredplace'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Check if user is authenticated
        if (!session()->has('user_id')) {
            return redirect()->route('login')->with('error', 'You must be logged in to write a review.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'sacredplace_id' => 'required|exists:sacredplaces,id',
        ]);

        // Check if the user has already reviewed this sacred place
        $existingReview = Review::where('user_id', session('user_id'))
            ->where('sacredplace_id', $validated['sacredplace_id'])
            ->first();

        if ($existingReview) {
            return redirect()->route('sacredplaces.show', Sacredplace::find($validated['sacredplace_id']))
                ->with('error', 'You have already reviewed this sacred place. You can edit your existing review.');
        }

        // Create the review
        $review = Review::create([
            'title' => $validated['title'],
            'body' => $validated['body'],
            'rating' => $validated['rating'],
            'sacredplace_id' => $validated['sacredplace_id'],
            'user_id' => session('user_id'),
        ]);

        return redirect()->route('sacredplaces.show', Sacredplace::find($validated['sacredplace_id']))
            ->with('success', 'Review created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Review $review)
    {
        // Reviews are typically viewed in the context of a sacred place
        return redirect()->route('sacredplaces.show', $review->sacredplace);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Review $review)
    {
        // Check if user is authenticated
        if (!session()->has('user_id')) {
            session()->put('url.intended', url()->current());
            return redirect()->route('login')->with('error', 'You must be logged in to edit a review.');
        }

        // Check if the user is the owner of the review
        if ($review->user_id != session('user_id')) {
            return redirect()->route('sacredplaces.show', $review->sacredplace)
                ->with('error', 'You can only edit your own reviews.');
        }

        $sacredplace = $review->sacredplace;

        return view('reviews.edit', compact('review', 'sacredplace'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Review $review)
    {
        // Check if user is authenticated
        if (!session()->has('user_id')) {
            return redirect()->route('login')->with('error', 'You must be logged in to update a review.');
        }

        // Check if the user is the owner of the review
        if ($review->user_id != session('user_id')) {
            return redirect()->route('sacredplaces.show', $review->sacredplace)
                ->with('error', 'You can only update your own reviews.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        // Update the review
        $review->update([
            'title' => $validated['title'],
            'body' => $validated['body'],
            'rating' => $validated['rating'],
        ]);

        return redirect()->route('sacredplaces.show', $review->sacredplace)
            ->with('success', 'Review updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Review $review)
    {
        // Check if user is authenticated
        if (!session()->has('user_id')) {
            return redirect()->route('login')->with('error', 'You must be logged in to delete a review.');
        }

        // Check if the user is the owner of the review
        if ($review->user_id != session('user_id')) {
            return redirect()->route('sacredplaces.show', $review->sacredplace)
                ->with('error', 'You can only delete your own reviews.');
        }

        $sacredplace = $review->sacredplace;

        // Delete the review
        $review->delete();

        return redirect()->route('sacredplaces.show', $sacredplace)
            ->with('success', 'Review deleted successfully.');
    }
}
