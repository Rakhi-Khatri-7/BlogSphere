@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="auth-container">
    <div class="auth-card">
        <div class="auth-header">
            <h2>Create Account</h2>
            <p>Join our blogging community today</p>
        </div>

        @if ($errors->any())
            <div class="alert alert-error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="/register" class="auth-form">
            @csrf
            
            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" 
                       id="name" 
                       name="name" 
                       value="{{ old('name') }}"
                       placeholder="Enter your name"
                       required 
                       autofocus>
            </div>

            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" 
                       id="email" 
                       name="email" 
                       value="{{ old('email') }}"
                       placeholder="Enter your email"
                       required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" 
                       id="password" 
                       name="password" 
                       placeholder="Minimum 6 characters"
                       required>
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirm Password</label>
                <input type="password" 
                       id="password_confirmation" 
                       name="password_confirmation" 
                       placeholder="Re-enter your password"
                       required>
            </div>

            <button type="submit" class="btn btn-primary btn-block">
                Create Account
            </button>
        </form>

        <div class="auth-footer">
            <p>Already have an account? <a href="/login">Login here</a></p>
        </div>
    </div>
</div>
@endsection