<?php

namespace App\Filament\Resources\ProficiencySkillResource\Pages;

use App\Filament\Resources\ProficiencySkillResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProficiencySkill extends EditRecord
{
    protected static string $resource = ProficiencySkillResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

