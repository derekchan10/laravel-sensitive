# Laravel-sensitive

Sensitive Fliter for Laravel5 based on [geek-dc/laravel-sensitive](https://github.com/geek-dc/laravel-sensitive).


## Install

```shell
composer require yankewei/laravel-sensitive
```

## For Laravel

Add config

```shell
php artisan vendor:publish --provider=GeekDC\Sensitive\LaravelSensitiveProvider
```

Execute database migration

```shell
php artisan migrate
```


## Usage

Using facade:

```php
Sensitive::match($content); 
```

## License

MIT
