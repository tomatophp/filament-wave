<?php

namespace Wave\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class FilamentWaveInstall extends Command
{
    protected $name = 'filament-wave:install';

    protected $description = 'Install Filament Wave';

    public function handle()
    {
        Artisan::call('migrate');
        $this->info('Migrations completed');
        Artisan::call('db:seed', ['class' => '\\Wave\\Seeders\\DatabaseSeeder']);
        $this->info('Database seeder completed');
        Artisan::call('shield:generate', ['--panel' => 'admin', '--all' => true]);
        $this->info('Shield generated');
        Artisan::call('shield:super-admin');
        $this->info('Shield super admin generated');
        Artisan::call('vendor:publish', ['--tag' => 'wave-assets']);
        $this->info('Assets published');
        $this->warn('You can login at ' . config('app.url') . '/admin/login now using this credentials: admin@admin.com, password');
    }
}
