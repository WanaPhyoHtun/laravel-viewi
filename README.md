# [WIP] Laravel Viewi

[![Latest Version on Packagist](https://img.shields.io/packagist/v/protonemedia/laravel-viewi.svg?style=flat-square)](https://packagist.org/packages/protonemedia/laravel-viewi)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/protonemedia/laravel-viewi/run-tests?label=tests)](https://github.com/protonemedia/laravel-viewi/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/protonemedia/laravel-viewi/Check%20&%20fix%20styling?label=code%20style)](https://github.com/protonemedia/laravel-viewi/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/protonemedia/laravel-viewi.svg?style=flat-square)](https://packagist.org/packages/protonemedia/laravel-viewi)

This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.

## Launcher 🚀

Hey! We've built a Docker-based deployment tool to launch apps and sites fully containerized. You can find all features and the roadmap on our [website](https://uselauncher.com), and we are on [Twitter](https://twitter.com/uselauncher) as well!

## Support

We proudly support the community by developing Laravel packages and giving them away for free. Keeping track of issues and pull requests takes time, but we're happy to help! If this package saves you time or if you're relying on it professionally, please consider [supporting the maintenance and development](https://github.com/sponsors/pascalbaljet).

## Installation

You can install the package via composer:

```bash
composer require protonemedia/laravel-viewi
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="laravel-viewi-config"
```

Add the `ViewiMiddleware` to the `web` group:

```php
class Kernel extends HttpKernel
{
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\ViewiMiddleware::class,
            ...
        ],
    ];
}
```

## Usage

Add Viewi components as regular Laravel routes, for example, in `web.php`:

```php
use App\Components\Views\Home\HomePage;
use App\Components\Views\NotFound\NotFoundPage;
use App\Components\Views\Pages\CounterPage;
use App\Components\Views\Pages\TodoAppPage;
use Illuminate\Support\Facades\Route;

Route::get('/', HomePage::class);
Route::get('/counter', CounterPage::class);
Route::get('/todo', TodoAppPage::class);
Route::get('*', NotFoundPage::class);
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Pascal Baljet](https://github.com/pascalbaljet)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
