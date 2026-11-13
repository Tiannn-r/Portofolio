<?php

namespace App\Filament\Resources\TechnicalSkillResource\Pages;

use App\Filament\Resources\TechnicalSkillResource;
use Filament\Resources\Pages\CreateRecord;

class CreateTechnicalSkill extends CreateRecord
{
    protected static string $resource = TechnicalSkillResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $type = $data['icon_type'] ?? 'url';

        if ($type === 'svg') {
            $data['icon'] = $data['icon_svg'] ?? null;
        } elseif ($type === 'upload') {
            $data['icon'] = $data['icon_file'] ?? null;
        } else {
            $data['icon'] = $data['icon_url'] ?? null;
        }

        unset($data['icon_type'], $data['icon_url'], $data['icon_file'], $data['icon_svg']);

        return $data;
    }
}
