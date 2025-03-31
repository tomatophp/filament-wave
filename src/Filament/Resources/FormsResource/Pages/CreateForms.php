<?php

namespace Wave\Filament\Resources\FormsResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Wave\Filament\Resources\FormsResource;

class CreateForms extends CreateRecord
{
    protected static string $resource = FormsResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['fields'] = json_encode($data['fields'], true);

        return $data;
    }
}
