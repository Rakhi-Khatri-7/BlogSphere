<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    // Show all favorites
    public function index()
    {
        $favorites = auth()->user()->favorites()
            ->with('user')
            ->latest('favorites.created_at')
            ->get();  // 👈 CHANGE: paginate(9) se get() kar diya
        
        return view('favorites.index', compact('favorites'));
    }
    
    // Add to favorites
    public function store($blogId)
    {
        $blog = Blog::findOrFail($blogId);
        
        if (auth()->user()->hasFavorited($blogId)) {
            return back()->with('error', 'Already in your favorites!');
        }
        
        auth()->user()->favorites()->attach($blogId);
        
        return back()->with('success', 'Added to favorites!');
    }
    
    // Remove from favorites
    public function destroy($blogId)
    {
        auth()->user()->favorites()->detach($blogId);
        
        return back()->with('success', 'Removed from favorites!');
    }
}