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
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->json('roles'); // Array JSON untuk typing effect, e.g. ["Full-Stack Developer", "UI/UX Designer"]
            $table->text('short_bio');
            $table->longText('about_me');
            $table->string('avatar')->nullable();
            $table->string('cv_file')->nullable();
            $table->boolean('is_available')->default(true);
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('location')->nullable();
            $table->json('social_links')->nullable();
            $table->unsignedInteger('happy_clients')->default(0);
            $table->unsignedInteger('projects_completed')->default(0);
            $table->unsignedInteger('years_experience')->default(0);
            $table->unsignedInteger('awards_received')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
