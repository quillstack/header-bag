# Quillstack Headers

[![Tests](https://github.com/quillstack/header-bag/actions/workflows/tests.yml/badge.svg)](https://github.com/quillstack/header-bag/actions/workflows/tests.yml)
[![Latest Version](https://img.shields.io/packagist/v/quillstack/header-bag.svg)](https://packagist.org/packages/quillstack/header-bag)
[![Downloads](https://img.shields.io/packagist/dt/quillstack/header-bag.svg)](https://packagist.org/packages/quillstack/header-bag)
[![PHP Version](https://img.shields.io/packagist/php-v/quillstack/header-bag)](https://packagist.org/packages/quillstack/header-bag)
[![StyleCI](https://github.styleci.io/repos/295142725/shield?branch=main)](https://github.styleci.io/repos/295142725?branch=main)
[![CodeFactor](https://www.codefactor.io/repository/github/quillstack/header-bag/badge)](https://www.codefactor.io/repository/github/quillstack/header-bag)
[![Quality Gate](https://sonarcloud.io/api/project_badges/measure?project=quillstack_header-bag&metric=alert_status)](https://sonarcloud.io/summary/new_code?id=quillstack_header-bag)
[![Coverage](https://sonarcloud.io/api/project_badges/measure?project=quillstack_header-bag&metric=coverage)](https://sonarcloud.io/summary/new_code?id=quillstack_header-bag)
[![Maintainability](https://sonarcloud.io/api/project_badges/measure?project=quillstack_header-bag&metric=sqale_rating)](https://sonarcloud.io/summary/new_code?id=quillstack_header-bag)
[![Reliability](https://sonarcloud.io/api/project_badges/measure?project=quillstack_header-bag&metric=reliability_rating)](https://sonarcloud.io/summary/new_code?id=quillstack_header-bag)
[![Security](https://sonarcloud.io/api/project_badges/measure?project=quillstack_header-bag&metric=security_rating)](https://sonarcloud.io/summary/new_code?id=quillstack_header-bag)
[![Maintainability](https://api.codeclimate.com/v1/badges/47cc5782df40c9082f8b/maintainability)](https://codeclimate.com/github/quillstack/header-bag/maintainability)
[![License](https://img.shields.io/packagist/l/quillstack/header-bag)](https://github.com/quillstack/header-bag/blob/main/LICENSE)

A simple solution to use headers according to [PSR-7](https://www.php-fig.org/psr/psr-7/).
Full documentation: https://quillstack.org/header-bag

Headers are not a map of strings. One name can carry several values, they are matched without
regard to case, and the wire format is not the format anything wants to work with. This holds
them the way PSR-7 says they are held, and leaves the joining and splitting to the places that
actually need it.

## Why this exists

HTTP header names do not care about case. `Content-Type`, `content-type` and `CONTENT-TYPE` are
the same header, and a client somewhere will send each of them. Every PSR-7 message has to
handle that, and in most implementations the handling lives inside the message class — so if you
want headers anywhere else, you carry a whole request or response around to get them.

This is that part on its own: a bag which matches without regard for case, and which nothing
else in this framework has to reimplement. Requests, responses and the HTTP client all use the
same one.

## Requirements

- PHP 8.1 or newer

## Installation

```shell
composer require quillstack/header-bag
```

## Usage

### Reading

```php
use Quillstack\HeaderBag\HeaderBag;

$headers = new HeaderBag([
    'Content-Type' => 'application/json',
    'Set-Cookie' => ['a=1', 'b=2'],
]);

$headers->getHeader('content-type');      // ['application/json']
$headers->getHeaderLine('Set-Cookie');    // 'a=1, b=2'
$headers->hasHeader('CONTENT-TYPE');      // true
$headers->getHeaders();                   // ['Content-Type' => [...], 'Set-Cookie' => [...]]
```

A name is matched without regard to case, and kept as it was first written.

### Changing

Every change gives back a copy, so the bag you were handed stays as it was:

```php
$next = $headers
    ->withHeader('Content-Type', 'text/plain')
    ->withAddedHeader('Set-Cookie', 'c=3')
    ->withoutHeader('X-Debug');
```

`withHeader()` replaces every value under that name; `withAddedHeader()` puts one beside the
ones already there.

## Technical documentation

`HeaderBag` implements `HeaderBagInterface`, which is this package's own rather than PSR-7's
`MessageInterface` — a bag of headers is not a message, and pretending otherwise means
implementing methods about bodies and protocol versions that have nothing to do with it.

| Method | Answers |
| --- | --- |
| `getHeaders(): array` | every header, as `name => string[]` |
| `getHeader(string $name): array` | the values under one name, or `[]` |
| `getHeaderLine(string $name): string` | those values joined with `, ` |
| `hasHeader(string $name): bool` | whether there are any |
| `withHeader(string $name, string\|array $value): static` | a copy with that name replaced |
| `withAddedHeader(string $name, string\|array $value): static` | a copy with one more value |
| `withoutHeader(string $name): static` | a copy without that name |

`getHeaders()` returns a list of values per name — never a comma-joined string. Joining is
what `getHeaderLine()` is for, and splitting on commas would break every header whose value
legitimately contains one, a date among them.

`InvalidHeaderArgumentException` (extending `HeaderBagException`) is thrown when a value is
neither a string nor a list of them.

## Benchmark

There is one comparable library. `symfony/http-foundation` has a `HeaderBag` that does the same
job standalone; `nyholm/psr7`, `guzzlehttp/psr7` and `laminas-diactoros` all keep their header
handling inside the message classes, so there is nothing there to compare a bag against.

Measured with [quillstack/benchmark](https://github.com/quillstack/benchmark) on five headers,
built and read back by a name in the wrong case, a thousand times. Runs are interleaved, each
figure is the median of five, and PHP is 8.5.7.

| | Version |
| --- | --- |
| quillstack/header-bag | v0.7.0 |
| symfony/http-foundation | v7.4.17 |

| | Per bag | Relative |
| --- | --- | --- |
| symfony/http-foundation | 3.21 µs | 0.67× |
| **quillstack/header-bag** | **4.82 µs** | — |

**Symfony's is faster**, by about a third. Its `HeaderBag` also does rather more — cache-control
directives, cookies, date parsing — while carrying `symfony/http-foundation`, which is 768 kB
and a dependency on the rest of that component. This package is 16 kB and answers to
`HeaderBagInterface`.

At under five microseconds a bag, neither number decides anything: a request builds one of
these.

## Tests

```shell
composer test
```

## The rest of Quillstack

This is one component of [Quillstack](https://github.com/quillstack), a PHP framework which is
as simple to use as it is strict about what it does.

- [quillstack/response](https://github.com/quillstack/response) — which carries one
- [quillstack/server-request](https://github.com/quillstack/server-request) — which carries one too
- [quillstack/http-client](https://github.com/quillstack/http-client) — and so does what it sends
- [quillstack/parameter-bag](https://github.com/quillstack/parameter-bag) — the same idea, without the case

## License

MIT. See [LICENSE](LICENSE).
