# PHP client for DuckDuckGo API

[![Latest Version](https://img.shields.io/packagist/v/gentle/duckduckgo-api.svg?style=flat-square)](https://packagist.org/packages/gentle/duckduckgo-api)
[![License](https://img.shields.io/badge/license-MIT-blue.svg?style=flat-square)](https://github.com/gentlero/duckduckgo-api/blob/master/LICENSE)
[![Build Status](http://img.shields.io/travis/gentlero/duckduckgo-api/master.svg?style=flat-square)](https://travis-ci.org/gentlero/duckduckgo-api)
[![Coverage Status](https://img.shields.io/scrutinizer/coverage/b/gentlero/duckduckgo-api/master.svg?style=flat-square)](https://scrutinizer-ci.com/b/gentlero/duckduckgo-api/?branch=master)
[![Code quality](http://img.shields.io/scrutinizer/b/gentlero/duckduckgo-api/master.svg?style=flat-square)](https://scrutinizer-ci.com/b/gentlero/duckduckgo-api/?branch=master)

This is a PHP library which offers support to access [DuckDuckGo] API.

## Requirements

* PHP >= 5.3 with following extensions enabled:
    * [cURL](http://php.net/manual/en/book.curl.php)
    * [OpenSSL](http://php.net/manual/en/book.openssl.php)
* [Buzz](https://github.com/kriswallsmith/Buzz) library.
* PHPUnit to run tests. (_optional_)

## Install

Via Composer

``` bash
$ composer require gentle/duckduckgo-api
```

## Documentation

See the [docs] directory for details and example(s).

## Testing

``` bash
$ phpunit
```

## License

Licensed under the MIT License - see the LICENSE file for details.

[docs]: https://github.com/gentlero/duckduckgo-api/tree/develop/docs
[DuckDuckGo]: https://duckduckgo.com/
