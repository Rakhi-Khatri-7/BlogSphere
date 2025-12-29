@extends('layouts.app')

@section('title', 'Manage Users')

@section('content')
<div class="container">
    <div class="page-header">
        <h1>User Management</h1>
        <p>View and manage all registered users</p>
    </div>

    <div class="card">
        <h2 style="margin-bottom: 2rem;">All Users ({{ $users->count() }})</h2>

        @if($users->count() > 0)
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="background: #f7fafc; border-bottom: 2px solid #e2e8f0;">
                            <th style="padding: 1rem; text-align: left;">ID</th>
                            <th style="padding: 1rem; text-align: left;">Name</th>
                            <th style="padding: 1rem; text-align: left;">Email</th>
                            <th style="padding: 1rem; text-align: left;">Role</th>
                            <th style="padding: 1rem; text-align: left;">Blogs</th>
                            <th style="padding: 1rem; text-align: left;">Joined</th>
                            <th style="padding: 1rem; text-align: center;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr style="border-bottom: 1px solid #e2e8f0;">
                                <td style="padding: 1rem;">{{ $user->id }}</td>
                                <td style="padding: 1rem;">{{ $user->name }}</td>
                                <td style="padding: 1rem;">{{ $user->email }}</td>
                                <td style="padding: 1rem;">
                                    @if($user->isAdmin())
                                        <span class="admin-badge"><i class="fas fa-crown"></i> Admin</span>
                                    @else
                                        <span style="padding: 0.4rem 0.875rem; background: #e2e8f0; color: #4a5568; border-radius: 20px; font-size: 0.85rem;">User</span>
                                    @endif
                                </td>
                                <td style="padding: 1rem;">{{ $user->blogs_count }}</td>
                                <td style="padding: 1rem;">{{ $user->created_at->format('M d, Y') }}</td>
                                <td style="padding: 1rem;">
                                    <div style="display: flex; gap: 0.5rem; justify-content: center;">
                                        <a href="/admin/users/{{ $user->id }}" class="btn btn-primary" style="padding: 0.5rem 1rem;">View</a>
                                        @if(!$user->isAdmin())
                                            <a href="/admin/users/{{ $user->id }}/delete" class="btn btn-danger" style="padding: 0.5rem 1rem;" onclick="return confirm('Delete {{ $user->name }}?')">Delete</a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection