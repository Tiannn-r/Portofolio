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
    ];

    protected function casts(): array
    {
        return [
            'roles' => 'array',
            'social_links' => 'array',
            'is_available' => 'boolean',
            'happy_clients' => 'integer',
            'projects_completed' => 'integer',
            'years_experience' => 'integer',
            'awards_received' => 'integer',
        ];
    }
}
