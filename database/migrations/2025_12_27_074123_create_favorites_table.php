<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('favorites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('blog_id')->constrained('blogs')->onDelete('cascade');
            $table->timestamps();
            
            // Prevent duplicate favorites
            $table->unique(['user_id', 'blog_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('favorites');
    }
};