![Screenshot](https://raw.githubusercontent.com/tomatophp/filament-wave/master/arts/3x1io-tomato-wave.jpg)

# Filament Wave

[![Latest Stable Version](https://poser.pugx.org/tomatophp/filament-wave/version.svg)](https://packagist.org/packages/tomatophp/filament-wave)
[![License](https://poser.pugx.org/tomatophp/filament-wave/license.svg)](https://packagist.org/packages/tomatophp/filament-wave)
[![Downloads](https://poser.pugx.org/tomatophp/filament-wave/d/total.svg)](https://packagist.org/packages/tomatophp/filament-wave)

Wave Kit with custom builder for TomatoPHP Plugins

## Screenshots

![Wave Kit Light](https://raw.githubusercontent.com/tomatophp/filament-wave/master/arts/light.png)
![Wave Kit Dark](https://raw.githubusercontent.com/tomatophp/filament-wave/master/arts/dark.png)

## Installation

```bash
composer require tomatophp/filament-wave
```

after install you need to add `HasRoles` to your `User.php` model like this

```php
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;
    use HasRoles;
}
```

and on your `routes/web.php` add this line and remove all other routes

```php
\Wave\Facades\Wave::routes();
```

and on your `config/auth.php` we need to add `accounts` guard like this

```php
'guards' => [
    'web' => [
        'driver' => 'session',
        'provider' => 'users',
    ],
    'accounts' => [
        'driver' => 'session',
        'provider' => 'accounts',
    ],
],

'providers' => [
    'users' => [
        'driver' => 'eloquent',
        'model' => env('AUTH_MODEL', App\Models\User::class),
    ],
    'accounts' => [
        'driver' => 'eloquent',
        'model' => App\Models\Account::class,
    ],
]
```

then you can run this command

```bash
php artisan config:cache
php artisan filament:install --panels
php artisan filament-wave:install
npm i
npm run build
php artisan optimize
```

if you are not using this package as a plugin please register the plugin on `/app/Providers/Filament/AdminPanelProvider.php`

```php
->plugin(\Wave\FilamentWavePlugin::make())
```


## Testing

if you like to run `PEST` testing just use this command

```bash
composer test
```

## Code Style

if you like to fix the code style just use this command

```bash
composer format
```

## PHPStan

if you like to check the code by `PHPStan` just use this command

```bash
composer analyse
```

## Other Filament Packages

Checkout our [Awesome TomatoPHP](https://github.com/tomatophp/awesome)
