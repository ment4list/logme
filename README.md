# Logme

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

A simple logger

## Structure

```
src/
tests/
vendor/
```


## Install

Via Composer

``` bash
$ composer require mentalist/logme
```

## Usage

``` php
// Instantiate
$logger = new Logme();

// Log info
$logger->info("This is some information.");

// Log error
$logger->info("This is a serious error!", [
    'file' => __FILE__,
    'foo' => 'bar',
]);

// Log to different location
$dir = "/var/tmp/daily/";
$date = date('Y-m-d');
$file = "tmp-{$date}.log";

$logger = new Logme($dir, $file);
$logger->warn('This is a warning.');
```

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CODE_OF_CONDUCT](CODE_OF_CONDUCT.md) for details.

## Security

If you discover any security related issues, please email tooone777@gmail.com instead of using the issue tracker.

## Credits

- [Jurgens Banninga][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/Mentalist/Logme.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/Mentalist/Logme/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/Mentalist/Logme.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/Mentalist/Logme.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/Mentalist/Logme.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/Mentalist/Logme
[link-travis]: https://travis-ci.org/Mentalist/Logme
[link-scrutinizer]: https://scrutinizer-ci.com/g/Mentalist/Logme/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/Mentalist/Logme
[link-downloads]: https://packagist.org/packages/Mentalist/Logme
[link-author]: https://github.com/ment4list
[link-contributors]: ../../contributors
