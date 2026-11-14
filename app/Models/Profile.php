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

    protected $appends = ['avatar_url', 'hero_image_url', 'about_image_url', 'cv_url', 'social_channels'];

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

    public function getSocialChannelsAttribute(): array
    {
        $links = $this->social_links ?? [];
        if (!is_array($links)) {
            return [];
        }

        $channels = [];
        $isAssociative = !empty($links) && array_keys($links) !== range(0, count($links) - 1);

        if ($isAssociative) {
            foreach ($links as $name => $url) {
                if (empty($url)) continue;
                $nameLower = strtolower($name);
                $isFormal = in_array($nameLower, ['linkedin', 'whatsapp', 'email', 'gmail', 'telegram']);
                $channels[] = [
                    'name' => ucfirst($name),
                    'platform' => $nameLower,
                    'category' => $isFormal ? 'formal' : 'social',
                    'url' => $url,
                    'subtext' => $isFormal ? ($nameLower === 'linkedin' ? 'Terhubung Profesional' : ($nameLower === 'whatsapp' ? 'Chat Cepat' : 'Kirim Pesan Langsung')) : '',
                    'logo_source' => 'preset',
                    'logo_url' => null,
                    'logo_file_url' => null,
                ];
            }
        } else {
            foreach ($links as $item) {
                if (empty($item['url'])) continue;
                $platform = strtolower($item['name'] ?? $item['platform'] ?? '');
                $logoFileUrl = !empty($item['logo_file']) ? asset('storage/' . ltrim($item['logo_file'], '/')) : null;
                $channels[] = [
                    'name' => $item['name'] ?? ucfirst($platform),
                    'platform' => $platform,
                    'category' => $item['category'] ?? 'social',
                    'url' => $item['url'],
                    'subtext' => $item['subtext'] ?? '',
                    'logo_source' => $item['logo_source'] ?? 'preset',
                    'logo_url' => $item['logo_url'] ?? null,
                    'logo_file_url' => $logoFileUrl,
                ];
            }
        }

        return $channels;
    }
}
