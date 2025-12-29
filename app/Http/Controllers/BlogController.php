<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    // Show all blogs with search
    public function index(Request $request)
    {
        $search = $request->search;
        
        $blogs = Blog::with('user')
            ->when($search, function($query) use ($search) {
                $query->where('title', 'like', "%{$search}%")
                      ->orWhere('content', 'like', "%{$search}%");
            })
            ->latest()
            ->get();  // 👈 CHANGE: paginate(9) se get() kar diya
        
        return view('blogs.index', compact('blogs', 'search'));
    }
    
    // Show single blog
    public function show($id)
    {
        $blog = Blog::with('user')->findOrFail($id);
        return view('blogs.show', compact('blog'));
    }
    
    // Show create form
    public function create()
    {
        return view('blogs.create');
    }
    
    // Store new blog
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'image' => 'nullable|image|max:2048'
        ]);
        
        $imageName = null;
        
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images'), $imageName);
        }
        
        Blog::create([
            'user_id' => auth()->id(),
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'image' => $imageName
        ]);
        
        return redirect('/blogs')->with('success', 'Blog created successfully!');
    }
    
    // Show edit form
    public function edit($id)
    {
        $blog = Blog::findOrFail($id);
        
        if ($blog->user_id != auth()->id()) {
            abort(403);
        }
        
        return view('blogs.edit', compact('blog'));
    }
    
    // Update blog
    public function update(Request $request, $id)
    {
        $blog = Blog::findOrFail($id);
        
        if ($blog->user_id != auth()->id()) {
            abort(403);
        }
        
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'image' => 'nullable|image|max:2048'
        ]);
        
        $imageName = $blog->image;
        
        if ($request->hasFile('image')) {
            if ($blog->image && file_exists(public_path('images/' . $blog->image))) {
                unlink(public_path('images/' . $blog->image));
            }
            
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images'), $imageName);
        }
        
        $blog->update([
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'image' => $imageName
        ]);
        
        return redirect('/blogs')->with('success', 'Blog updated successfully!');
    }
    
    // Delete blog
    public function destroy($id)
    {
        $blog = Blog::findOrFail($id);
        
        if ($blog->user_id != auth()->id() && !auth()->user()->isAdmin()) {
            abort(403);
        }
        
        if ($blog->image && file_exists(public_path('images/' . $blog->image))) {
            unlink(public_path('images/' . $blog->image));
        }
        
        $blog->delete();
        
        return redirect('/blogs')->with('success', 'Blog deleted successfully!');
    }

    // Show only current user's blogs
    public function myBlogs()
    {
        $blogs = auth()->user()->blogs()
            ->latest()
            ->get();  // 👈 CHANGE: paginate(9) se get() kar diya
    
        return view('blogs.my-blogs', compact('blogs'));
    }
}