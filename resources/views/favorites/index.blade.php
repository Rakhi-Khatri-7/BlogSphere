@extends('layouts.app')

@section('title', 'My Favorites')

@section('content')
<div class="container">
    <div class="page-header">
        <h1>❤️ My Favorites</h1>
        <p>Blogs you've saved for later</p>
    </div>

    @if($favorites->count() > 0)
        <div class="blog-grid">
            @foreach($favorites as $blog)
                <div class="blog-card">
                    @if($blog->image)
                        <img src="{{ asset('images/' . $blog->image) }}" alt="{{ $blog->title }}">
                    @else
                        <div class="image-placeholder">
                            <i class="fas fa-blog"></i>
                        </div>
                    @endif
                    
                    <div class="blog-card-body">
                        <h3 class="blog-card-title">{{ Str::limit($blog->title, 50) }}</h3>
                        <p class="blog-card-text">{{ Str::limit($blog->content, 100) }}</p>
                        
                        <div class="blog-card-footer">
                            <small>By: {{ $blog->user->name ?? 'Unknown' }}</small>
                            <a href="/blogs/{{ $blog->id }}" class="btn btn-primary" style="padding: 0.5rem 1rem;">Read</a>
                        </div>

                        <div style="margin-top: 1rem;">
                            <form method="POST" action="/favorites/{{ $blog->id }}" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" style="width: 100%; padding: 0.5rem;">
                                    <i class="fas fa-heart-broken"></i> Remove from Favorites
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    @else
        <div class="card text-center" style="padding: 3rem;">
            <i class="fas fa-heart" style="font-size: 4rem; color: #cbd5e1; margin-bottom: 1rem;"></i>
            <h3>No Favorites Yet</h3>
            <p class="text-muted">Start adding blogs to your favorites!</p>
            <a href="/blogs" class="btn btn-primary" style="margin-top: 1rem;">Browse Blogs</a>
        </div>
    @endif
</div>
@endsection