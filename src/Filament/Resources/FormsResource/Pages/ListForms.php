<?php

namespace Wave\Filament\Resources\FormsResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Wave\Filament\Resources\FormsResource;

class ListForms extends ListRecords
{
    protected static string $resource = FormsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
