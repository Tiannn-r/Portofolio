<?php

namespace App\Filament\Resources\ServiceResource\Pages;

use App\Filament\Resources\ServiceResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditService extends EditRecord
{
    protected static string $resource = ServiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $icon = trim($data['icon'] ?? '');

        if (str_starts_with($icon, '<svg')) {
            $data['icon_type'] = 'svg';
            $data['icon_svg'] = $icon;
            $data['icon_url'] = null;
            $data['icon_file'] = null;
        } elseif (filter_var($icon, FILTER_VALIDATE_URL)) {
            $data['icon_type'] = 'url';
            $data['icon_url'] = $icon;
            $data['icon_svg'] = null;
            $data['icon_file'] = null;
        } elseif (!empty($icon)) {
            $data['icon_type'] = 'upload';
            $data['icon_file'] = $icon;
            $data['icon_url'] = null;
            $data['icon_svg'] = null;
        } else {
            $data['icon_type'] = 'url';
            $data['icon_url'] = null;
            $data['icon_file'] = null;
            $data['icon_svg'] = null;
        }

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
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
