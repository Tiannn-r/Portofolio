<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Story extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'category',
        'summary',
        'content',
        'thumbnail',
        'event_date',
        'tags',
        'url',
        'is_featured',
        'order',
    ];

    protected $appends = ['thumbnail_url'];

    protected function casts(): array
    {
        return [
            'tags' => 'array',
            'is_featured' => 'boolean',
            'order' => 'integer',
        ];
    }

    public function getThumbnailUrlAttribute(): ?string
    {
        if (!$this->thumbnail) {
            return null;
        }

        return filter_var($this->thumbnail, FILTER_VALIDATE_URL)
            ? $this->thumbnail
            : asset('storage/' . ltrim($this->thumbnail, '/'));
    }
}
