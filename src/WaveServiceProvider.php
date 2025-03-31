<?php

namespace Wave;

use Filament\Support\Colors\Color;
use Filament\Support\Facades\FilamentColor;
use Illuminate\Auth\Middleware\RedirectIfAuthenticated;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Foundation\Http\Middleware\ValidateCsrfToken;
use Illuminate\Foundation\Vite as BaseVite;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\Compilers\BladeCompiler;
use Laravel\Folio\Folio;
use Livewire\Livewire;
use TomatoPHP\FilamentTypes\Facades\FilamentTypes;
use TomatoPHP\FilamentTypes\Services\Contracts\Type;
use TomatoPHP\FilamentTypes\Services\Contracts\TypeFor;
use TomatoPHP\FilamentTypes\Services\Contracts\TypeOf;
use Wave\Console\Commands\FilamentWaveInstall;
use Wave\Facades\Wave as WaveFacade;
use Wave\Overrides\Vite;
use Wave\Plugins\PluginServiceProvider;

class WaveServiceProvider extends ServiceProvider
{
    public function register()
    {
        $loader = AliasLoader::getInstance();
        $loader->alias('Wave', WaveFacade::class);

        $this->app->singleton('wave', function () {
            return new Wave;
        });

        $this->loadHelpers();

        $this->loadLivewireComponents();

        $this->app->router->aliasMiddleware('paddle-webhook-signature', \Wave\Http\Middleware\VerifyPaddleWebhookSignature::class);
        $this->app->router->aliasMiddleware('subscribed', \Wave\Http\Middleware\Subscribed::class);
        $this->app->router->aliasMiddleware('token_api', \Wave\Http\Middleware\TokenMiddleware::class);

        if (! $this->hasDBConnection()) {
            $this->app->router->pushMiddlewareToGroup('web', \Wave\Http\Middleware\InstallMiddleware::class);
        }

        if (config('wave.demo')) {
            $this->app->router->pushMiddlewareToGroup('web', \Wave\Http\Middleware\ThemeDemoMiddleware::class);
            // Overwrite the Vite asset helper so we can use the demo folder as opposed to the build folder
            $this->app->singleton(BaseVite::class, function ($app) {
                // Replace the default Vite instance with the custom one
                return new Vite;
            });
        }

        // Register the PluginServiceProvider
        $this->app->register(PluginServiceProvider::class);

        $this->mergeConfigFrom(__DIR__ . '/../config/wave.php', 'wave');
        $this->mergeConfigFrom(__DIR__ . '/../config/permission.php', 'permission');

    }

    private function setSchemaDefaultLength(): void
    {
        try {
            Schema::defaultStringLength(191);
        } catch (\Exception $exception) {
        }
    }

    public function boot(Router $router, Dispatcher $event)
    {

        if ($this->app->environment() == 'production') {
            $this->app['request']->server->set('HTTPS', true);
        }

        $this->setSchemaDefaultLength();

        Validator::extend('base64image', function ($attribute, $value, $parameters, $validator) {
            $explode = explode(',', $value);
            $allow = ['png', 'jpg', 'svg', 'jpeg'];
            $format = str_replace(
                [
                    'data:image/',
                    ';',
                    'base64',
                ],
                [
                    '', '', '',
                ],
                $explode[0]
            );

            // check file format
            if (! in_array($format, $allow)) {
                return false;
            }

            // check base64 format
            if (! preg_match('%^[a-zA-Z0-9/+]*={0,2}$%', $explode[1])) {
                return false;
            }

            return true;
        });

        FilamentTypes::register([
            TypeFor::make('home')
                ->label('Home Sections')
                ->types([
                    TypeOf::make('hero-section')
                        ->label('Hero Section'),
                    TypeOf::make('feature-section')
                        ->label('Feature Section'),
                    TypeOf::make('testimonials-section')
                        ->label('Testimonials Section'),
                ]),
            TypeFor::make('dashboard')
                ->label('Dashboard Sections')
                ->types([
                    TypeOf::make('widget')
                        ->label('Dashboard Widgets'),
                    TypeOf::make('sidebar-menu')
                        ->label('Sidebar Menu')
                        ->register([
                            Type::make('https://docs.3x1.io/circlexo')
                                ->name([
                                    'ar' => 'طريقة الاستخدام',
                                    'en' => 'Docs',
                                ])
                                ->icon('phosphor-book-bookmark-duotone'),
                            Type::make('https://github.com/orgs/circlexo/discussions')
                                ->name([
                                    'ar' => 'الأسئلة الشائعة',
                                    'en' => 'Questions',
                                ])
                                ->icon('phosphor-chat-duotone'),
                            Type::make('https://github.com/orgs/circlexo/discussions')
                                ->name([
                                    'ar' => 'الأسئلة الشائعة',
                                    'en' => 'Questions',
                                ])
                                ->icon('phosphor-chat-duotone'),
                        ]),
                ]),
        ]);

        Relation::morphMap([
            'users' => config('wave.user_model'),
        ]);

        $this->registerFilamentComponentsFriendlyNames();

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'wave');
        $this->loadMigrationsFrom(realpath(__DIR__ . '/../database/migrations'));
        $this->loadBladeDirectives();
        $this->setDefaultThemeColors();

        FilamentColor::register([
            'danger' => Color::Red,
            'gray' => Color::Zinc,
            'info' => Color::Blue,
            'primary' => config('wave.primary_color'),
            'success' => Color::Green,
            'warning' => Color::Amber,
        ]);

        if ($this->app->runningInConsole()) {
            $this->commands([
                FilamentWaveInstall::class,
                \Wave\Console\Commands\CancelExpiredSubscriptions::class,
                \Wave\Console\Commands\CreatePluginCommand::class,
            ]);
            // $this->excludeInactiveThemes();

            $this->publishes([
                __DIR__ . '/../publish/public' => public_path(),
                __DIR__ . '/../publish/app' => app_path(),
                __DIR__ . '/../publish/config' => config_path(),
                __DIR__ . '/../publish/storage' => storage_path(),
                __DIR__ . '/../publish/resources' => resource_path(),
                __DIR__ . '/../publish/postcss.config.js' => base_path('postcss.config.js'),
                __DIR__ . '/../publish/tailwind.config.js' => base_path('tailwind.config.js'),
                __DIR__ . '/../publish/theme.json' => base_path('theme.json'),
                __DIR__ . '/../publish/vite.config.js' => base_path('vite.config.js'),
                __DIR__ . '/../publish/package.json' => base_path('package.json'),
            ], 'wave-assets');
        }

        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang');

        $this->publishes([
            __DIR__ . '/../publish/resources/lang' => resource_path('lang'),
        ], 'wave-lang');

        Relation::morphMap([
            'user' => config('auth.providers.model'),
            'form' => \App\Models\Forms::class,
            // Add other mappings as needed
        ]);

        $this->registerWaveFolioDirectory();
        $this->registerWaveComponentDirectory();



        $this->app['router']->pushMiddlewareToGroup('web', \RalphJSmit\Livewire\Urls\Middleware\LivewireUrlsMiddleware::class);
        $this->app['router']->pushMiddlewareToGroup('web', \Wave\Http\Middleware\LanguageMiddleware::class);

        ValidateCsrfToken::except([
            '/webhook/paddle',
            '/webhook/stripe',
        ]);

        EncryptCookies::except([
            'theme',
        ]);

        RedirectIfAuthenticated::redirectUsing(fn()=>'dashboard');
    }

    protected function loadHelpers()
    {
        foreach (glob(__DIR__ . '/Helpers/*.php') as $filename) {
            require_once $filename;
        }
    }

    protected function loadMiddleware()
    {
        foreach (glob(__DIR__ . '/Http/Middleware/*.php') as $filename) {
            require_once $filename;
        }
    }

    protected function loadBladeDirectives()
    {

        // app()->afterResolving('blade.compiler', function (BladeCompiler $bladeCompiler) {
        // @admin directives
        Blade::if('admin', function () {
            return ! auth('accounts')->guest() && auth('accounts')->user()->isAdmin();
        });

        // @subscriber directives
        Blade::if('subscriber', function () {
            return ! auth('accounts')->guest() && auth('accounts')->user()->subscriber();
        });

        // @notsubscriber directives
        Blade::if('notsubscriber', function () {
            return ! auth('accounts')->guest() && ! auth('accounts')->user()->subscriber();
        });

        // Subscribed Directives
        Blade::if('subscribed', function ($plan) {
            return ! auth('accounts')->guest() && auth('accounts')->user()->subscribedToPlan($plan);
        });

        // home directives
        Blade::if('home', function () {
            return request()->is('/');
        });

    }

    protected function registerFilamentComponentsFriendlyNames()
    {
        // Blade::component('filament::components.avatar', 'avatar');
        Blade::component('filament::components.dropdown.index', 'dropdown');
        Blade::component('filament::components.dropdown.list.index', 'dropdown.list');
        Blade::component('filament::components.dropdown.list.item', 'dropdown.list.item');
    }

    protected function registerWaveFolioDirectory()
    {
        if (File::exists(base_path('wave/resources/views/pages'))) {
            Folio::path(base_path('wave/resources/views/pages'))->middleware([
                '*' => [
                    //
                ],
            ]);
        }
    }

    protected function registerWaveComponentDirectory()
    {
        Blade::anonymousComponentPath(base_path('/resources/views/components'));
    }

    private function loadLivewireComponents()
    {
        Livewire::component('billing.checkout', \Wave\Http\Livewire\Billing\Checkout::class);
        Livewire::component('billing.update', \Wave\Http\Livewire\Billing\Update::class);
    }

    protected function setDefaultThemeColors()
    {
        if (config('wave.demo')) {
            $theme = $this->getActiveTheme();

            if (isset($theme->id)) {
                if (Cookie::get('theme')) {
                    $theme_cookied = \DevDojo\Themes\Models\Theme::where('folder', '=', Cookie::get('theme'))->first();
                    if (isset($theme_cookied->id)) {
                        $theme = $theme_cookied;
                    }
                }

                $default_theme_color = match ($theme->folder) {
                    'anchor' => '#000000',
                    'blank' => '#090909',
                    'cove' => '#0069ff',
                    'drift' => '#000000',
                    'fusion' => '#0069ff'
                };

                Config::set('wave.primary_color', $default_theme_color);
            }
        }
    }

    protected function getActiveTheme()
    {
        return \Wave\Theme::where('active', 1)->first();
    }

    protected function hasDBConnection()
    {
        $hasDatabaseConnection = true;

        try {
            DB::connection()->getPdo();
        } catch (\Exception $e) {
            $hasDatabaseConnection = false;
        }

        return $hasDatabaseConnection;
    }
}
