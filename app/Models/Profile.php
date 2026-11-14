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
        $channels = [];

        // If $links is already a numeric array from a previous Repeater format
        if (is_array($links) && !empty($links) && array_keys($links) === range(0, count($links) - 1)) {
            foreach ($links as $item) {
                if (empty($item['url'])) continue;
                $logoFileUrl = !empty($item['logo_file']) ? asset('storage/' . ltrim($item['logo_file'], '/')) : null;
                $channels[] = [
                    'name' => $item['name'] ?? 'Platform',
                    'platform' => strtolower($item['name'] ?? $item['platform'] ?? 'custom'),
                    'category' => $item['category'] ?? 'social',
                    'url' => $item['url'],
                    'subtext' => $item['subtext'] ?? '',
                    'logo_source' => $item['logo_source'] ?? 'preset',
                    'logo_url' => $item['logo_url'] ?? null,
                    'logo_file_url' => $logoFileUrl,
                ];
            }
            return $channels;
        }

        // 1. Formal Channels:
        // LinkedIn
        $linkedinUrl = null;
        if (is_array($links)) {
            $linkedinUrl = $links['linkedin_url'] ?? ($links['linkedin'] ?? ($links['formal']['linkedin']['url'] ?? null));
        }
        if (!empty($linkedinUrl)) {
            $channels[] = [
                'name' => 'LinkedIn',
                'platform' => 'linkedin',
                'category' => 'formal',
                'url' => $linkedinUrl,
                'subtext' => (is_array($links) ? ($links['linkedin_subtext'] ?? ($links['formal']['linkedin']['subtext'] ?? null)) : null) ?: 'Terhubung Profesional',
                'logo_source' => 'preset',
                'logo_url' => null,
                'logo_file_url' => null,
            ];
        }

        // Email Langsung
        $emailAddr = !empty($this->email) ? $this->email : 'ibnhu.work@gmail.com';
        if (!empty($emailAddr)) {
            $emailSubtext = is_array($links) ? ($links['email_subtext'] ?? ($links['formal']['email']['subtext'] ?? null)) : null;
            $channels[] = [
                'name' => 'Email Langsung',
                'platform' => 'email',
                'category' => 'formal',
                'url' => 'mailto:' . $emailAddr,
                'subtext' => $emailSubtext ?: $emailAddr,
                'logo_source' => 'preset',
                'logo_url' => null,
                'logo_file_url' => null,
            ];
        }

        // WhatsApp
        $phoneNum = !empty($this->phone) ? $this->phone : '+62 812-3456-7890';
        if (!empty($phoneNum)) {
            $cleanPhone = preg_replace('/[^0-9]/', '', $phoneNum);
            if (str_starts_with($cleanPhone, '0')) {
                $cleanPhone = '62' . substr($cleanPhone, 1);
            }
            $waSubtext = is_array($links) ? ($links['whatsapp_subtext'] ?? ($links['formal']['whatsapp']['subtext'] ?? null)) : null;
            $channels[] = [
                'name' => 'WhatsApp',
                'platform' => 'whatsapp',
                'category' => 'formal',
                'url' => 'https://wa.me/' . $cleanPhone,
                'subtext' => $waSubtext ?: 'Chat & Diskusi Cepat',
                'logo_source' => 'preset',
                'logo_url' => null,
                'logo_file_url' => null,
            ];
        }

        // 2. Media Sosial di Footer:
        $socialDefs = [
            'github' => 'GitHub',
            'tiktok' => 'TikTok',
            'youtube' => 'YouTube',
            'instagram' => 'Instagram',
            'twitter' => 'Twitter / X',
        ];

        foreach ($socialDefs as $key => $label) {
            $url = is_array($links) ? ($links[$key . '_url'] ?? ($links[$key] ?? ($key === 'twitter' ? ($links['x'] ?? null) : null))) : null;
            if (!empty($url)) {
                $channels[] = [
                    'name' => $label,
                    'platform' => $key,
                    'category' => 'social',
                    'url' => $url,
                    'subtext' => '',
                    'logo_source' => 'preset',
                    'logo_url' => null,
                    'logo_file_url' => null,
                ];
            }
        }

        // 3. Saluran Kustom / Tambahan
        $customs = is_array($links) ? ($links['custom_channels'] ?? []) : [];
        if (is_array($customs)) {
            foreach ($customs as $c) {
                if (empty($c['url'])) continue;
                $logoFileUrl = !empty($c['logo_file']) ? asset('storage/' . ltrim($c['logo_file'], '/')) : null;
                $channels[] = [
                    'name' => $c['name'] ?? 'Platform',
                    'platform' => strtolower($c['name'] ?? 'custom'),
                    'category' => $c['category'] ?? 'social',
                    'url' => $c['url'],
                    'subtext' => $c['subtext'] ?? '',
                    'logo_source' => $c['logo_source'] ?? 'preset',
                    'logo_url' => $c['logo_url'] ?? null,
                    'logo_file_url' => $logoFileUrl,
                ];
            }
        }

        return $channels;
    }
}
