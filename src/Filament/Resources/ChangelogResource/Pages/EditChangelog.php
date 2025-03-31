<?php

namespace Wave\Filament\Resources\ChangelogResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Wave\Filament\Resources\ChangelogResource;

class EditChangelog extends EditRecord
{
    protected static string $resource = ChangelogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
