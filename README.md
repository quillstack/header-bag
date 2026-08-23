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

### Requirements

- PHP 8.1 or newer

### Installation

```shell
composer require quillstack/header-bag
```

### Usage

#### Reading

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

#### Changing

Every change gives back a copy, so the bag you were handed stays as it was:

```php
$next = $headers
    ->withHeader('Content-Type', 'text/plain')
    ->withAddedHeader('Set-Cookie', 'c=3')
    ->withoutHeader('X-Debug');
```

`withHeader()` replaces every value under that name; `withAddedHeader()` puts one beside the
ones already there.

### Technical documentation

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

### Unit tests

```shell
composer test
```

### Docker

```shell
docker-compose up -d
docker exec -w /var/www/html -it quillstack_header-bag sh
```

### License

MIT. See [LICENSE](LICENSE).
