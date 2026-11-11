<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('stories', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('category')->default('News'); // Career Milestone, Tech Story, Achievement, Event, etc.
            $table->text('summary');
            $table->longText('content');
            $table->string('thumbnail')->nullable();
            $table->string('event_date')->nullable(); // e.g. "November 2026"
            $table->json('tags')->nullable(); // e.g. ["Architecture", "Laravel", "Awards"]
            $table->string('url')->nullable(); // External article or media link
            $table->boolean('is_featured')->default(true);
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stories');
    }
};
