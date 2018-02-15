# Php Bootstrapping

[![Latest Version](https://img.shields.io/github/release/harryosmar/php-bootstrap.svg?style=flat-square)](https://github.com/harryosmar/php-bootstrap/releases)
[![Build Status](https://travis-ci.org/harryosmar/php-bootstrap.svg?branch=master)](https://travis-ci.org/harryosmar/php-bootstrap)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/harryosmar/php-bootstrap/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/harryosmar/php-bootstrap/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/harryosmar/php-bootstrap/badges/build.png?b=master)](https://scrutinizer-ci.com/g/harryosmar/php-bootstrap/build-status/master)

## Features
- Routing
- Console
- Middleware
- Dependency Injection
- Response for RESTful APIs https://github.com/harryosmar/php-restful-api-response

## Requirements
- php >= 7.0
- composer https://getcomposer.org/download/

## How To Setup
```
git clone git@github.com:harryosmar/php-bootstrap.git
cd php-bootstrap
composer install
```

or just download the [latest release](https://github.com/harryosmar/php-bootstrap/releases)


## How To Use
*Show Task List*
```
php launcher.php list
```
*Run Task* `php launcher.php {taskname}`
```
php launcher.php app:helloword
```
*Open endpoints url*
```
php -S localhost:8000
```
then open http://localhost:8000 in your browser


## How To Run The Test
```
composer test
```

## How To Contribute
- Fork this repo
- post an issue https://github.com/harryosmar/php-bootstrap/issues
- create the PR(Pull Request) and wait for the review

### How To Add new route url
- add your new route in route collections
[https://github.com/harryosmar/php-bootstrap/blob/master/src/Routes.php](https://github.com/harryosmar/php-bootstrap/blob/master/src/Routes.php)

### How To Add new console Task
- *Follow documentation* [here](https://symfony.com/doc/current/console.html) : how to create new console task
- add your console task file to this folder
[https://github.com/harryosmar/php-bootstrap/tree/master/src/Console](https://github.com/harryosmar/php-bootstrap/tree/master/src/Console)
- then register your console task in [https://github.com/harryosmar/php-bootstrap/blob/master/src/Tasks.php](https://github.com/harryosmar/php-bootstrap/blob/master/src/Tasks.php)

