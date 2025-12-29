@extends('layouts.app')

@section('title', 'My Profile')

@section('content')
<div class="container" style="max-width: 900px;">
    <div class="page-header">
        <h1>My Profile</h1>
        <p>Manage your account settings</p>
    </div>

    <!-- Profile Info Card -->
    <div class="card">
        <h2 style="margin-bottom: 1.5rem;">Profile Information</h2>

        <form method="POST" action="/profile/update">
            @csrf
            
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" 
                       id="name" 
                       name="name" 
                       value="{{ old('name', auth()->user()->name) }}"
                       required>
                @error('name')
                    <small style="color: #ef4444;">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" 
                       id="email" 
                       name="email" 
                       value="{{ old('email', auth()->user()->email) }}"
                       required>
                @error('email')
                    <small style="color: #ef4444;">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label>Role</label>
                <div>
                    @if(auth()->user()->isAdmin())
                        <span class="admin-badge">
                            <i class="fas fa-crown"></i> Admin
                        </span>
                    @else
                        <span style="padding: 0.4rem 0.875rem; background: #e2e8f0; color: #4a5568; border-radius: 20px; font-size: 0.85rem; font-weight: 600;">
                            <i class="fas fa-user"></i> User
                        </span>
                    @endif
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Update Profile</button>
        </form>
    </div>

    <!-- Change Password Card -->
    <div class="card">
        <h2 style="margin-bottom: 1.5rem;">Change Password</h2>

        <form method="POST" action="/profile/password">
            @csrf
            
            <div class="form-group">
                <label for="current_password">Current Password</label>
                <input type="password" 
                       id="current_password" 
                       name="current_password" 
                       placeholder="Enter your current password"
                       required>
                @error('current_password')
                    <small style="color: #ef4444;">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="new_password">New Password</label>
                <input type="password" 
                       id="new_password" 
                       name="new_password" 
                       placeholder="Enter new password (minimum 6 characters)"
                       required>
                @error('new_password')
                    <small style="color: #ef4444;">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="new_password_confirmation">Confirm New Password</label>
                <input type="password" 
                       id="new_password_confirmation" 
                       name="new_password_confirmation" 
                       placeholder="Re-enter new password"
                       required>
            </div>

            <button type="submit" class="btn btn-warning">Update Password</button>
        </form>
    </div>

    <!-- My Blogs Stats -->
    <div class="card">
        <h2 style="margin-bottom: 1.5rem;">My Blogs</h2>
        <div class="stats-grid">
            <div class="stat-card">
                <h3>{{ auth()->user()->blogs()->count() }}</h3>
                <p>Total Blogs</p>
            </div>
            <div class="stat-card">
                <h3>{{ auth()->user()->created_at->format('M Y') }}</h3>
                <p>Member Since</p>
            </div>
        </div>
        <a href="/my-blogs" class="btn btn-outline" style="margin-top: 1.5rem;">View All My Blogs</a>
    </div>

    <!-- Danger Zone -->
    <div class="card danger-zone">
        <h2 style="margin-bottom: 1.5rem; color: #ef4444;">Danger Zone</h2>
        <p class="text-muted" style="margin-bottom: 1.5rem;">Once you delete your account, all your blogs will be permanently deleted.</p>

        <form method="POST" action="/profile/delete" onsubmit="return confirm('Are you sure? This cannot be undone!');">
            @csrf
            
            <div class="form-group">
                <label for="password">Confirm Password to Delete Account</label>
                <input type="password" 
                       id="password" 
                       name="password" 
                       placeholder="Enter your password to confirm deletion"
                       required>
                @error('password')
                    <small style="color: #ef4444;">{{ $message }}</small>
                @enderror
            </div>

            <button type="submit" class="btn btn-danger">Delete My Account</button>
        </form>
    </div>
</div>
@endsection