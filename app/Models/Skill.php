<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'icon',
        'percentage',
        'type',
        'order',
    ];

    protected function casts(): array
    {
        return [
            'percentage' => 'integer',
            'order' => 'integer',
        ];
    }

    protected $appends = ['icon_url'];

    public function getIconUrlAttribute(): ?string
    {
        if (!$this->icon) {
            return null;
        }

        return filter_var($this->icon, FILTER_VALIDATE_URL)
            ? $this->icon
            : (str_starts_with($this->icon, '<svg') ? null : asset('storage/' . ltrim($this->icon, '/')));
    }
}
