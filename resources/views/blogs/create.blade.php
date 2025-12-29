@extends('layouts.app')

@section('title', 'Create Blog')

@section('content')
<div class="container">
    <div class="page-header">
        <h1>Create New Blog</h1>
        <p>Share your thoughts with the world</p>
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

        <form method="POST" action="/blogs" enctype="multipart/form-data">
            @csrf
            
            <div class="form-group">
                <label for="title">Blog Title</label>
                <input type="text" 
                       id="title" 
                       name="title" 
                       value="{{ old('title') }}"
                       placeholder="Enter blog title"
                       required>
            </div>

            <div class="form-group">
                <label for="content">Blog Content</label>
                <textarea id="content" 
                          name="content" 
                          rows="10"
                          placeholder="Write your blog content here..."
                          required>{{ old('content') }}</textarea>
            </div>

            <div class="form-group">
                <label for="image">Featured Image (Optional)</label>
                <input type="file" 
                       id="image" 
                       name="image" 
                       accept="image/*">
                <small class="text-muted">Max size: 2MB</small>
            </div>

            <div style="display: flex; gap: 1rem;">
                <button type="submit" class="btn btn-primary">Publish Blog</button>
                <a href="/blogs" class="btn btn-outline">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection