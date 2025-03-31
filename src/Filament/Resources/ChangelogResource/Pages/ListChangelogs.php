<?php

namespace Wave\Filament\Resources\ChangelogResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Wave\Filament\Resources\ChangelogResource;

class ListChangelogs extends ListRecords
{
    protected static string $resource = ChangelogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
