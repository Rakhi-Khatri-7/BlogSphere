@extends('layouts.app')

@section('title', 'All Blogs')

@section('content')
<div class="container">
    <div class="page-header">
        <h1>All Blogs</h1>
        <p>Discover amazing stories from our community</p>
    </div>

    <!-- Search Bar -->
    <div class="search-container">
        <form method="GET" action="/blogs" style="display: flex; gap: 1rem; width: 100%;">
            <input type="text" 
                   name="search" 
                   placeholder="Search blogs..." 
                   value="{{ $search ?? '' }}">
            <button type="submit" class="btn btn-primary">Search</button>
        </form>
    </div>

    <!-- Blogs Grid -->
    @if($blogs->count() > 0)
        <div class="blog-grid">
            @foreach($blogs as $blog)
                <div class="blog-card">
                    @if($blog->image)
                        <img src="{{ asset('images/' . $blog->image) }}" alt="{{ $blog->title }}">
                    @else
                        <div style="height: 220px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-blog" style="font-size: 3rem; color: white; opacity: 0.5;"></i>
                        </div>
                    @endif
                    
                    <div class="blog-card-body">
                        <h3 class="blog-card-title">{{ Str::limit($blog->title, 50) }}</h3>
                        <p class="blog-card-text">{{ Str::limit($blog->content, 100) }}</p>
                        
                        <div class="blog-card-footer">
                            <small>By: {{ $blog->user->name ?? 'Unknown' }}</small>
                            <a href="/blogs/{{ $blog->id }}" class="btn btn-primary" style="padding: 0.5rem 1rem;">Read</a>
                        </div>

                        @auth
                            <div style="margin-top: 1rem; padding-top: 1rem; border-top: 1px solid #e2e8f0;">
                                @if(auth()->user()->hasFavorited($blog->id))
                                    <form method="POST" action="/favorites/{{ $blog->id }}" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn" style="width: 100%; padding: 0.5rem; background: #ef4444; color: white;">
                                            <i class="fas fa-heart"></i> Remove from Favorites
                                        </button>
                                    </form>
                                @else
                                    <form method="POST" action="/favorites/{{ $blog->id }}" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="btn" style="width: 100%; padding: 0.5rem; background: #10b981; color: white;">
                                            <i class="far fa-heart"></i> Add to Favorites
                                        </button>
                                    </form>
                                @endif
                            </div>
                        @endauth

                        @auth
                            @if($blog->user_id === auth()->id() || auth()->user()->isAdmin())
                                <div style="margin-top: 1rem; display: flex; gap: 0.5rem;">
                                    @if($blog->user_id === auth()->id())
                                        <a href="/blogs/{{ $blog->id }}/edit" class="btn btn-warning" style="flex: 1; padding: 0.5rem;">Edit</a>
                                    @endif
                                    <a href="/blogs/{{ $blog->id }}/delete" 
                                       class="btn btn-danger" 
                                       style="flex: 1; padding: 0.5rem;"
                                       onclick="return confirm('Delete this blog?')">Delete</a>
                                </div>
                            @endif
                        @endauth
                    </div>
                </div>
            @endforeach
        </div>
        
        <!-- ❌ PAGINATION DELETED - NO MORE PAGINATION HERE -->
        
    @else
        <div class="card text-center" style="padding: 3rem;">
            <h3>No blogs found</h3>
            <p class="text-muted">Be the first to create a blog!</p>
            @auth
                <a href="/blogs/create/new" class="btn btn-primary">Create Blog</a>
            @endauth
        </div>
    @endif
</div>
@endsection