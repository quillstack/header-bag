# Quillstack Headers

[![Build Status](https://app.travis-ci.com/quillstack/header-bag.svg?branch=master)](https://app.travis-ci.com/quillstack/header-bag)
[![Downloads](https://img.shields.io/packagist/dt/quillstack/header-bag.svg)](https://packagist.org/packages/quillstack/header-bag)
[![Coverage](https://sonarcloud.io/api/project_badges/measure?project=quillstack_header-bag&metric=coverage)](https://sonarcloud.io/dashboard?id=quillstack_header-bag)
[![Lines of Code](https://sonarcloud.io/api/project_badges/measure?project=quillstack_header-bag&metric=ncloc)](https://sonarcloud.io/dashboard?id=quillstack_header-bag)
[![StyleCI](https://github.styleci.io/repos/295142725/shield?branch=main)](https://github.styleci.io/repos/295142725?branch=main)
[![CodeFactor](https://www.codefactor.io/repository/github/quillstack/header-bag/badge)](https://www.codefactor.io/repository/github/quillstack/header-bag)
![Packagist License](https://img.shields.io/packagist/l/quillstack/header-bag)
[![Reliability Rating](https://sonarcloud.io/api/project_badges/measure?project=quillstack_header-bag&metric=reliability_rating)](https://sonarcloud.io/dashboard?id=quillstack_header-bag)
[![Maintainability](https://api.codeclimate.com/v1/badges/47cc5782df40c9082f8b/maintainability)](https://codeclimate.com/github/quillstack/header-bag/maintainability)
[![Security Rating](https://sonarcloud.io/api/project_badges/measure?project=quillstack_header-bag&metric=security_rating)](https://sonarcloud.io/dashboard?id=quillstack_header-bag)
![Packagist PHP Version Support](https://img.shields.io/packagist/php-v/quillstack/header-bag)

A simple solution to use headers according to PSR-7. You can install this library, if you need to use headers
in your project. This implementation can be used in HTTP requests and responses. 
You can find the full documentation on the website: \
https://quillstack.org/headers

### Unit tests

Run tests using a command:

```
phpdbg -qrr vendor/bin/phpunit
```

Check the tests coverage:

```
phpdbg -qrr vendor/bin/phpunit --coverage-html coverage tests
```

## Docker

```shell
$ docker-compose up -d
$ docker exec -w /var/www/html -it quillstack_header-bag sh
```
