<?php

namespace Wave;

use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use Filament\Contracts\Plugin;
use Filament\FontProviders\GoogleFontProvider;
use Filament\Panel;
use TomatoPHP\FilamentAccounts\FilamentAccountsPlugin;
use TomatoPHP\FilamentLanguageSwitcher\FilamentLanguageSwitcherPlugin;
use TomatoPHP\FilamentMenus\FilamentMenusPlugin;
use TomatoPHP\FilamentSettingsHub\FilamentSettingsHubPlugin;
use TomatoPHP\FilamentTypes\FilamentTypesPlugin;
use TomatoPHP\FilamentUsers\FilamentUsersPlugin;
use Wave\Filament\Widgets;
use Wave\Filament\Pages;
use Wave\Filament\Resources;

class FilamentWavePlugin implements Plugin
{
    public function getId(): string
    {
        return 'filament-wave';
    }

    private $dynamicWidgets = [];

    public function boot(Panel $panel): void
    {
        // TODO: Implement boot() method.
    }

    public function register(Panel $panel): void
    {
        $panel->widgets([
            Widgets\WaveInfoWidget::class,
            Widgets\WelcomeWidget::class,
            Widgets\UsersWidget::class,
            Widgets\PostsPagesWidget::class,
            ...$this->dynamicWidgets,
        ]);

        $panel->pages([
            Pages\Themes::class,
            Pages\Media::class,
            Pages\Dashboard::class,
        ]);

        $panel->resources([
            Resources\CategoryResource::class,
            Resources\ChangelogResource::class,
            Resources\FormsResource::class,
            Resources\PageResource::class,
            Resources\PlanResource::class,
            Resources\PostResource::class,
        ]);

        $panel->sidebarCollapsibleOnDesktop()
            ->unsavedChangesAlerts()
            ->databaseNotifications()
            ->viteTheme('resources/css/filament/admin/theme.css')
            ->path('admin')
            ->favicon(asset('favicon.ico'))
            ->brandLogoHeight('45px')
            ->brandLogo(fn () => view('wave::admin.logo'))
            ->darkModeBrandLogo(fn () => view('wave::admin.logo-dark'))
            ->login()
            ->profile()
            ->font(
                'Readex Pro',
                provider: GoogleFontProvider::class,
            );

        $panel->plugin(FilamentShieldPlugin::make());
        $panel->plugin(FilamentLanguageSwitcherPlugin::make());
        $panel->plugin(FilamentUsersPlugin::make());
        $panel->plugin(FilamentTypesPlugin::make());
        $panel->plugin(FilamentSettingsHubPlugin::make());
        $panel->plugin(FilamentMenusPlugin::make());
        $panel->plugin(
            FilamentAccountsPlugin::make()
                ->useTypes()
                ->useAvatar()
                ->canLogin()
                ->canBlocked()
                ->useNotifications()
                ->useExport()
                ->useImport()
        );
    }

    public static function make(): self
    {
        return new self;
    }

    private function renderAnalyticsIfCredentialsExist()
    {
        if (file_exists(storage_path('app/analytics/service-account-credentials.json'))) {
            \Config::set('filament-google-analytics.page_views.filament_dashboard', true);
            \Config::set('filament-google-analytics.active_users_one_day.filament_dashboard', true);
            \Config::set('filament-google-analytics.active_users_seven_day.filament_dashboard', true);
            \Config::set('filament-google-analytics.active_users_twenty_eight_day.filament_dashboard', true);
            \Config::set('filament-google-analytics.most_visited_pages.filament_dashboard', true);
            \Config::set('filament-google-analytics.top_referrers_list.filament_dashboard', true);
        } else {
            $this->dynamicWidgets = [Widgets\AnalyticsPlaceholderWidget::class];
        }
    }
}
