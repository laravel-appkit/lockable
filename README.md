# Eloquent Lockable

[![Latest Version on Packagist](https://img.shields.io/packagist/v/laravel-appkit/lockable.svg?style=flat-square)](https://packagist.org/packages/laravel-appkit/lockable)
[![Build Status](https://img.shields.io/github/workflow/status/laravel-appkit/lockable/Automated%20Tests?style=flat-square)](https://github.com/laravel-appkit/lockable/actions?query=workflow%3A%22Automated+Tests%22)
[![Quality Score](https://img.shields.io/github/workflow/status/laravel-appkit/lockable/Check%20&%20fix%20styling?label=code%20quality&style=flat-square)](https://github.com/laravel-appkit/lockable/actions?query=workflow%3A%22Check+%26+fix+styling%22)
[![Total Downloads](https://img.shields.io/packagist/dt/laravel-appkit/lockable.svg?style=flat-square)](https://packagist.org/packages/laravel-appkit/lockable)
[![Licence](https://img.shields.io/packagist/l/laravel-appkit/lockable.svg?style=flat-square)](https://packagist.org/packages/laravel-appkit/lockable)

Allows a user to acquire a lock on a model, which prevents anyone else from being able to edit it.

## Installation

You can install the package via composer:

```bash
composer require laravel-appkit/lockable
```

## Usage

Add the `AppKit\Lockable\Traits\Lockable` trait to the model you want to set locks on

Add a `locked_by` integer column to the corresponding table. This can also be done using the `lockable` method on the migration.

``` php
<?php

namespace App\Models;

use AppKit\Lockable\Traits\Lockable;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use Lockable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'body'
    ];
}
```

### Acquiring Locks
To acquire a lock on a model, call the `acquireLock` method on it.

```php
$article->acquireLock();
```
### Releasing Locks
To release the existing lock on a model, call the `releaseLock` method on it.

```php
$article->releaseLock();
```
### Testing

``` bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email appkit-security@coutts.io instead of using the issue tracker.

Please see [SECURITY](.github/SECURITY.md) for more details.

## Credits

- [Darren Coutts](https://github.com/laravel-appkit)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
