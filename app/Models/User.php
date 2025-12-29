<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    // Check if user is admin
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    // Get user's blogs
    public function blogs()
    {
        return $this->hasMany(Blog::class);
    }

    public function favorites()
    {
        return $this->belongsToMany(Blog::class, 'favorites')->withTimestamps();
    }

    public function hasFavorited($blogId)
    {
        return $this->favorites()->where('blog_id', $blogId)->exists();
    }
}