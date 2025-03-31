<?php

namespace Wave\Filament\Resources\ChangelogResource\Pages;

use Wave\Filament\Resources\ChangelogResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

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
