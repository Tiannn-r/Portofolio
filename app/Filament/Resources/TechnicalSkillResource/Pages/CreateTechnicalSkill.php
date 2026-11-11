<?php

namespace App\Filament\Resources\TechnicalSkillResource\Pages;

use App\Filament\Resources\TechnicalSkillResource;
use Filament\Resources\Pages\CreateRecord;

class CreateTechnicalSkill extends CreateRecord
{
    protected static string $resource = TechnicalSkillResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['type'] = 'grid_icon';
        $data['percentage'] = 100;
        return $data;
    }
}

