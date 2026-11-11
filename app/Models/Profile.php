<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'roles',
        'short_bio',
        'about_me',
        'avatar',
        'hero_image',
        'about_image',
        'cv_file',
        'is_available',
        'email',
        'phone',
        'location',
        'social_links',
        'happy_clients',
        'projects_completed',
        'years_experience',
        'awards_received',
        'skills_overview',
    ];

    protected function casts(): array
    {
        return [
            'roles' => 'array',
            'social_links' => 'array',
            'skills_overview' => 'array',
            'is_available' => 'boolean',
            'happy_clients' => 'integer',
            'projects_completed' => 'integer',
            'years_experience' => 'integer',
            'awards_received' => 'integer',
        ];
    }

    protected $appends = ['avatar_url', 'hero_image_url', 'about_image_url', 'cv_url'];

    public function getAvatarUrlAttribute(): ?string
    {
        if (!$this->avatar) {
            return null;
        }

        return filter_var($this->avatar, FILTER_VALIDATE_URL)
            ? $this->avatar
            : asset('storage/' . ltrim($this->avatar, '/'));
    }

    public function getHeroImageUrlAttribute(): ?string
    {
        $src = $this->hero_image ?: $this->avatar;
        if (!$src) {
            return null;
        }

        return filter_var($src, FILTER_VALIDATE_URL)
            ? $src
            : asset('storage/' . ltrim($src, '/'));
    }

    public function getAboutImageUrlAttribute(): ?string
    {
        $src = $this->about_image ?: $this->avatar;
        if (!$src) {
            return null;
        }

        return filter_var($src, FILTER_VALIDATE_URL)
            ? $src
            : asset('storage/' . ltrim($src, '/'));
    }

    public function getCvUrlAttribute(): ?string
    {
        if (!$this->cv_file) {
            return null;
        }

        return filter_var($this->cv_file, FILTER_VALIDATE_URL)
            ? $this->cv_file
            : asset('storage/' . ltrim($this->cv_file, '/'));
    }
}
