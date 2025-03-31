<?php

namespace Wave\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use TomatoPHP\ConsoleHelpers\Traits\HandleFiles;
use TomatoPHP\ConsoleHelpers\Traits\RunCommand;

class FilamentWaveInstall extends Command
{
    use HandleFiles;
    use RunCommand;

    protected $name = 'filament-wave:install';

    protected $description = 'Install Filament Wave';


    public function handle()
    {
        $this->publish = __DIR__.'/../../../publish/';

        $fileExists = File::files(database_path('/migrations/'));
        foreach ($fileExists as $item){
            if(str($item)->contains('sites_settings')){
                File::delete($item->getPathname());
            }
        }

        Artisan::call('migrate');
        Artisan::call('filament-settings-hub:install');
        Artisan::call('notifications:table');
        $this->info('Migrations completed');
        Artisan::call('db:seed', ['class' => '\\Wave\\Seeders\\DatabaseSeeder']);
        $this->info('Database seeder completed');
        Artisan::call('shield:generate', ['--panel' => 'admin', '--all' => true]);
        $this->info('Shield generated');
        Artisan::call('shield:super-admin');
        $this->info('Shield super admin generated');
        Artisan::call('vendor:publish', ['--tag' => 'wave-assets']);
        $this->handelFile('vite.config.js', base_path('vite.config.js'));
        $this->handelFile('tailwind.config.js', base_path('tailwind.config.js'));
        $this->handelFile('postcss.config.js', base_path('postcss.config.js'));
        $this->handelFile('package.json', base_path('package.json'));
        $this->info('Assets published');
        $this->warn('run npm i & npm run build then you can login at ' . config('app.url') . '/admin/login now using this credentials: admin@admin.com, password');
    }
}
