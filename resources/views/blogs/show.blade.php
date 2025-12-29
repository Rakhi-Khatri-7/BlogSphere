@extends('layouts.app')

@section('title', $blog->title)

@section('content')
<div class="container" style="max-width: 900px;">
    <a href="/blogs" class="btn btn-outline" style="margin-bottom: 2rem;">â† Back to Blogs</a>

    <div class="card">
        @if($blog->image)
            <img src="{{ asset('images/' . $blog->image) }}" 
                 alt="{{ $blog->title }}"
                 style="width: 100%; height: 400px; object-fit: cover; border-radius: 12px; margin-bottom: 2rem;">
        @endif

        <div style="padding-bottom: 1.5rem; margin-bottom: 1.5rem; border-bottom: 2px solid #e2e8f0;">
            <h1 style="font-size: 2.5rem; margin-bottom: 1rem;">{{ $blog->title }}</h1>
            <div style="display: flex; gap: 1rem; color: #718096; font-size: 0.9rem;">
                <span><i class="fas fa-user"></i> {{ $blog->user->name ?? 'Unknown' }}</span>
                <span><i class="fas fa-calendar"></i> {{ $blog->created_at->format('M d, Y') }}</span>
            </div>

        @auth
            <div style="margin-top: 1rem;">
                @if(auth()->user()->hasFavorited($blog->id))
                    <form method="POST" action="/favorites/{{ $blog->id }}" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-heart"></i> Remove from Favorites
                        </button>
                    </form>
                @else
                    <form method="POST" action="/favorites/{{ $blog->id }}" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-success">
                            <i class="far fa-heart"></i> Add to Favorites
                        </button>
                    </form>
                @endif
            </div>
        @endauth
        </div>

        <div style="line-height: 1.8; font-size: 1.1rem; color: #2d3748;">
            {!! nl2br(e($blog->content)) !!}
        </div>

        @auth
            @if($blog->user_id === auth()->id() || auth()->user()->isAdmin())
                <div style="margin-top: 2rem; padding-top: 2rem; border-top: 2px solid #e2e8f0; display: flex; gap: 1rem;">
                    @if($blog->user_id === auth()->id())
                        <a href="/blogs/{{ $blog->id }}/edit" class="btn btn-warning">Edit Blog</a>
                    @endif
                    <a href="/blogs/{{ $blog->id }}/delete" 
                       class="btn btn-danger"
                       onclick="return confirm('Delete this blog?')">Delete Blog</a>
                </div>
            @endif
        @endauth
    </div>
</div>
@endsection