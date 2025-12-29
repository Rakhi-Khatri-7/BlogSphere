<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'BlogSphere - Your Space to Share Stories')</title>
    
    <!-- Single CSS File -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="container">
            <a href="/" class="logo">
                <i class="fas fa-blog"></i> BlogSphere
            </a>
            
            <ul class="nav-links">
                <li><a href="/blogs">All Blogs</a></li>
                
                @auth
                    <li><a href="/blogs/create/new">Create Blog</a></li>
                    <li><a href="/my-blogs">My Blogs</a></li>
                    <li><a href="/favorites">My Favorites</a></li>
                    <li><a href="/profile">Profile</a></li>

                    @if(auth()->user()->isAdmin())
                    <li><a href="/admin/users">Manage Users</a></li>
                    @endif
                    
                    @if(auth()->user()->isAdmin())
                        <li>
                            <span class="admin-badge">
                                <i class="fas fa-crown"></i> Admin
                            </span>
                        </li>
                    @endif
                    
                    <li>
                        <form method="POST" action="/logout" style="display: inline;">
                            @csrf
                            <button type="submit" style="background: none; border: none; color: #4a5568; font-weight: 500; cursor: pointer; font-size: 0.95rem;">
                                Logout ({{ auth()->user()->name }})
                            </button>
                        </form>
                    </li>
                @else
                    <li><a href="/login">Login</a></li>
                    <li><a href="/register" class="btn btn-primary" style="padding: 0.5rem 1.25rem;">Register</a></li>
                @endauth
            </ul>
        </div>
    </nav>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="container">
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        </div>
    @endif
    
    @if(session('error'))
        <div class="container">
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            </div>
        </div>
    @endif

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer style="background: white; padding: 2rem 0; margin-top: 4rem; text-align: center; box-shadow: 0 -2px 10px rgba(0,0,0,0.05);">
        <div class="container">
            <p style="color: #718096; margin: 0;">
                &copy; {{ date('Y') }} BlogSphere. Built with <i class="fas fa-heart" style="color: #f56565;"></i> using Laravel
            </p>
        </div>
    </footer>
</body>
</html>