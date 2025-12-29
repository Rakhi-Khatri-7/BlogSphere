@extends('layouts.app')

@section('title', 'Edit Blog')

@section('content')
<div class="container">
    <div class="page-header">
        <h1>Edit Blog</h1>
        <p>Update your blog content</p>
    </div>

    <div class="card" style="max-width: 800px; margin: 0 auto;">
        @if ($errors->any())
            <div class="alert alert-error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="/blogs/{{ $blog->id }}" enctype="multipart/form-data">
            @csrf
            
            <div class="form-group">
                <label for="title">Blog Title</label>
                <input type="text" 
                       id="title" 
                       name="title" 
                       value="{{ old('title', $blog->title) }}"
                       required>
            </div>

            <div class="form-group">
                <label for="content">Blog Content</label>
                <textarea id="content" 
                          name="content" 
                          rows="10"
                          required>{{ old('content', $blog->content) }}</textarea>
            </div>

            @if($blog->image)
                <div class="form-group">
                    <label>Current Image</label>
                    <img src="{{ asset('images/' . $blog->image) }}" 
                         alt="Current" 
                         style="max-width: 200px; border-radius: 8px; display: block; margin-top: 0.5rem;">
                </div>
            @endif

            <div class="form-group">
                <label for="image">Change Image (Optional)</label>
                <input type="file" 
                       id="image" 
                       name="image" 
                       accept="image/*">
            </div>

            <div style="display: flex; gap: 1rem;">
                <button type="submit" class="btn btn-warning">Update Blog</button>
                <a href="/blogs/{{ $blog->id }}" class="btn btn-outline">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection