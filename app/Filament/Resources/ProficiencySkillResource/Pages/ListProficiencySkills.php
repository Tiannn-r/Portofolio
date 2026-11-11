<?php

namespace App\Filament\Resources\ProficiencySkillResource\Pages;

use App\Filament\Resources\ProficiencySkillResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProficiencySkills extends ListRecords
{
    protected static string $resource = ProficiencySkillResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

