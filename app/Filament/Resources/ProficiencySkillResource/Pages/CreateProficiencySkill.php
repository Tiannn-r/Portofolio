<?php

namespace App\Filament\Resources\ProficiencySkillResource\Pages;

use App\Filament\Resources\ProficiencySkillResource;
use Filament\Resources\Pages\CreateRecord;

class CreateProficiencySkill extends CreateRecord
{
    protected static string $resource = ProficiencySkillResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['type'] = 'progress_bar';
        return $data;
    }
}

