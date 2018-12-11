# Log HTTP requests

[![Latest Version on Packagist](https://img.shields.io/packagist/v/spatie/laravel-http-logger.svg?style=flat-square)](https://packagist.org/packages/spatie/laravel-http-logger)
[![Build Status](https://img.shields.io/travis/spatie/laravel-http-logger/master.svg?style=flat-square)](https://travis-ci.org/spatie/laravel-http-logger)
[![Quality Score](https://img.shields.io/scrutinizer/g/spatie/laravel-http-logger.svg?style=flat-square)](https://scrutinizer-ci.com/g/spatie/laravel-http-logger)
[![Total Downloads](https://img.shields.io/packagist/dt/spatie/laravel-http-logger.svg?style=flat-square)](https://packagist.org/packages/spatie/laravel-http-logger)

功能描述：
  日志中间件，可通过route指定中间件来记录http请求的 header ,body,ip,response信息。并且当response错误时可发生邮件到指定邮箱（这需要配置好laravel自带的Mail）。
  这些参数都是可配置的。配置文件如下。


## Installation

You can install the package via composer:

```bash
composer require daisanmu/laravel-http-logger
```

Optionally you can publish the configfile with:

```bash
php artisan vendor:publish --provider="Spatie\HttpLogger\HttpLoggerServiceProvider" --tag="config" 
```

This is the contents of the published config file:

```php
return [

    /*
     * The log profile which determines whether a request should be logged.
     * It should implement `LogProfile`.
     */
    'log_profile' => \Spatie\HttpLogger\LogNonGetRequests::class,

    /*
     * The log writer used to write the request to a log.
     * It should implement `LogWriter`.
     */
    'log_writer' => \Spatie\HttpLogger\DefaultLogWriter::class,

    /*
     * Filter out body fields which will never be logged.
     */
    'except' => [
        'password',
        'password_confirmation',
    ],
    /*
     * Filter out header fields which will never be logged.
     */
    'except_header' => [
        'postman-token',
        'accept',
        'accept-language',
        'accept-encoding',
        'cache-control',
        'content-type',
        'content-length',
        'connection',
        'host',
        'user-agent',
        'origin'
    ],
    /**
     *指定错误发送邮件
    */
    'send_mail_status' => [
        '500'
    ],
    /**
     *指定到指定邮箱，需要配置laravel的Mail
    */
    'send_to' => [
        '10503331@qq.com'
    ]
];
```

## Usage

This packages provides a middleware which can be added as a global middleware or as a single route.

```php
// in `app/Http/Kernel.php`

protected $middleware = [
    // ...
    
    \Spatie\HttpLogger\Middlewares\HttpLogger::class
];
```

```php
// in a routes file

Route::post('/submit-form', function () {
    //
})->middleware(\Spatie\HttpLogger\Middlewares\HttpLogger::class);
```
在spatie/laravel-http-logger 基础上增加记录header IP 和response信息，当response为指定错误码时可发送邮件
```

fork 自 https://github.com/spatie/laravel-http-logger

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
