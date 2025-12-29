@extends('layouts.app')

@section('title', $user->name)

@section('content')
<div class="container">
    <a href="/admin/users" class="btn btn-outline" style="margin-bottom: 2rem;">← Back</a>

    <div class="card">
        <h1>{{ $user->name }}</h1>
        <p>{{ $user->email }}</p>
        
        @if($user->isAdmin())
            <span class="admin-badge"><i class="fas fa-crown"></i> Admin</span>
        @endif

        <div style="margin-top: 2rem;">
            <h3>Total Blogs: {{ $user->blogs()->count() }}</h3>
            <p>Member Since: {{ $user->created_at->format('M d, Y') }}</p>
        </div>

        @if(!$user->isAdmin())
            <a href="/admin/users/{{ $user->id }}/delete" class="btn btn-danger" style="margin-top: 2rem;" onclick="return confirm('Delete user?')">Delete User</a>
        @endif
    </div>

    <div class="card">
        <h2>{{ $user->name }}'s Blogs</h2>
        
        @if($blogs->count() > 0)
            <div class="blog-grid">
                @foreach($blogs as $blog)
                    <div class="blog-card">
                        @if($blog->image)
                            <img src="{{ asset('images/' . $blog->image) }}" alt="{{ $blog->title }}">
                        @endif
                        <div class="blog-card-body">
                            <h3>{{ $blog->title }}</h3>
                            <p>{{ Str::limit($blog->content, 100) }}</p>
                            <a href="/blogs/{{ $blog->id }}" class="btn btn-primary">View</a>
                            <a href="/blogs/{{ $blog->id }}/delete" class="btn btn-danger" onclick="return confirm('Delete?')">Delete</a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection