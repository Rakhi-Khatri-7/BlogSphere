@extends('layouts.app')

@section('title', 'My Blogs')

@section('content')
<div class="container">
    <div class="page-header">
        <h1>📝 My Blogs</h1>
        <p>Manage all your blog posts</p>
    </div>

    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <div>
            <h3 style="color: white; margin: 0;">Total: {{ $blogs->count() }} {{ $blogs->count() == 1 ? 'Blog' : 'Blogs' }}</h3>
        </div>
        <a href="/blogs/create/new" class="btn btn-success">
            <i class="fas fa-plus"></i> Create New Blog
        </a>
    </div>

    @if($blogs->count() > 0)
        <div class="blog-grid">
            @foreach($blogs as $blog)
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
                            <small><i class="fas fa-calendar"></i> {{ $blog->created_at->format('M d, Y') }}</small>
                            <a href="/blogs/{{ $blog->id }}" class="btn btn-primary" style="padding: 0.5rem 1rem;">View</a>
                        </div>

                        <div style="margin-top: 1rem; display: flex; gap: 0.5rem;">
                            <a href="/blogs/{{ $blog->id }}/edit" class="btn btn-warning" style="flex: 1; padding: 0.5rem;">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <a href="/blogs/{{ $blog->id }}/delete" 
                               class="btn btn-danger" 
                               style="flex: 1; padding: 0.5rem;"
                               onclick="return confirm('Delete this blog?')">
                                <i class="fas fa-trash"></i> Delete
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    @else
        <div class="card text-center" style="padding: 3rem;">
            <i class="fas fa-pen-fancy" style="font-size: 4rem; color: #cbd5e1; margin-bottom: 1rem;"></i>
            <h3>No Blogs Yet</h3>
            <p class="text-muted">Start creating your first blog post!</p>
            <a href="/blogs/create/new" class="btn btn-primary" style="margin-top: 1rem;">
                <i class="fas fa-plus"></i> Create Your First Blog
            </a>
        </div>
    @endif
</div>
@endsection