@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="auth-container">
    <div class="auth-card">
        <div class="auth-header">
            <h2>Welcome Back!</h2>
            <p>Login to continue to your blog</p>
        </div>

        @if ($errors->any())
            <div class="alert alert-error">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="/login" class="auth-form">
            @csrf
            
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" 
                       id="email" 
                       name="email" 
                       value="{{ old('email') }}"
                       placeholder="Enter your email"
                       required 
                       autofocus>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" 
                       id="password" 
                       name="password" 
                       placeholder="Enter your password"
                       required>
            </div>

            <button type="submit" class="btn btn-primary btn-block">
                Login
            </button>
        </form>

        <div class="auth-footer">
            <p>Don't have an account? <a href="/register">Register here</a></p>
        </div>
    </div>
</div>
@endsection