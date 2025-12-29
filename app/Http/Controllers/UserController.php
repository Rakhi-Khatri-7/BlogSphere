<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Blog;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // Show all users (Admin only)
    public function index()
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized access');
        }
        
        $users = User::withCount('blogs')
            ->orderBy('created_at', 'desc')
            ->get();  // 👈 CHANGE: paginate(10) se get() kar diya
        
        return view('admin.users.index', compact('users'));
    }
    
    // Show single user with their blogs (Admin only)
    public function show($id)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized access');
        }
        
        $user = User::with('blogs')->findOrFail($id);
        $blogs = $user->blogs()->latest()->get();  // 👈 CHANGE: paginate(6) se get() kar diya
        
        return view('admin.users.show', compact('user', 'blogs'));
    }
    
    // Delete user (Admin only, cannot delete admin)
    public function destroy($id)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized access');
        }
        
        $user = User::findOrFail($id);
        
        if ($user->isAdmin()) {
            return back()->with('error', 'Cannot delete admin accounts!');
        }
        
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete your own account from here!');
        }
        
        foreach ($user->blogs as $blog) {
            if ($blog->image && file_exists(public_path('images/' . $blog->image))) {
                unlink(public_path('images/' . $blog->image));
            }
        }
        
        $user->delete();
        
        return redirect('/admin/users')->with('success', 'User and all their blogs deleted successfully!');
    }
}