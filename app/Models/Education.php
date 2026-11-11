<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    use HasFactory;

    protected $table = 'educations';

    protected $fillable = [
        'title',
        'institution',
        'period',
        'description',
        'type',
        'order',
        'certificate_image',
        'event_name',
        'history',
        'credential_url',
    ];

    protected $appends = ['certificate_image_url'];

    protected function casts(): array
    {
        return [
            'order' => 'integer',
        ];
    }

    public function getCertificateImageUrlAttribute(): ?string
    {
        if (!$this->certificate_image) {
            return null;
        }

        return filter_var($this->certificate_image, FILTER_VALIDATE_URL)
            ? $this->certificate_image
            : asset('storage/' . ltrim($this->certificate_image, '/'));
    }
}
