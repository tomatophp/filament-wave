<?php

namespace Wave\Filament\Pages;

use Filament\Panel;

class Dashboard extends \Filament\Pages\Dashboard
{
    protected static ?string $navigationIcon = 'phosphor-house-duotone';

    public function panel(Panel $panel): Panel
    {
        return $panel
            ->pages([]);
    }
}
