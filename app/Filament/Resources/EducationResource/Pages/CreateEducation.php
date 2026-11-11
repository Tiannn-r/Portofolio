<?php

namespace App\Filament\Resources\EducationResource\Pages;

use App\Filament\Resources\EducationResource;
use Filament\Resources\Pages\CreateRecord;

class CreateEducation extends CreateRecord
{
    protected static string $resource = EducationResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['type'] = 'education';
        return $data;
    }
}
