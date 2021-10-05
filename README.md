# QuillStack Headers

[![Build Status](https://travis-ci.org/quillstack/header-bag.svg?branch=master)](https://travis-ci.org/quillstack/header-bag)
[![Quality Gate Status](https://sonarcloud.io/api/project_badges/measure?project=quillstack_header-bag&metric=alert_status)](https://sonarcloud.io/dashboard?id=quillstack_header-bag)
[![Downloads](https://img.shields.io/packagist/dt/quillstack/header-bag.svg)](https://packagist.org/packages/quillstack/header-bag)
[![StyleCI](https://github.styleci.io/repos/295142725/shield?branch=master)](https://github.styleci.io/repos/295142725?branch=master)
[![CodeFactor](https://www.codefactor.io/repository/github/quillstack/header-bag/badge)](https://www.codefactor.io/repository/github/quillstack/header-bag)
[![Maintainability Rating](https://sonarcloud.io/api/project_badges/measure?project=quillstack_header-bag&metric=sqale_rating)](https://sonarcloud.io/dashboard?id=quillstack_header-bag)
[![Lines of Code](https://sonarcloud.io/api/project_badges/measure?project=quillstack_header-bag&metric=ncloc)](https://sonarcloud.io/dashboard?id=quillstack_header-bag)
[![Coverage](https://sonarcloud.io/api/project_badges/measure?project=quillstack_header-bag&metric=coverage)](https://sonarcloud.io/dashboard?id=quillstack_header-bag)
![Packagist PHP Version Support](https://img.shields.io/packagist/php-v/quillstack/header-bag)
![Packagist License](https://img.shields.io/packagist/l/quillstack/header-bag)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/quillstack/header-bag/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/quillstack/header-bag/?branch=master)

A simple solution to use headers according to PSR-7. You can install this library, if you need to use headers
in your project. This implementation can be used in HTTP requests and responses. 
You can find the full documentation on the website: \
https://quillstack.com/headers

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
