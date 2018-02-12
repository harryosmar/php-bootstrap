# Php Bootstrapping

## Features
- Routing
- Console


## Requirements
- php >= 7.0
- composer https://getcomposer.org/download/

## How To Setup
```
git@github.com:harryosmar/php-bootstrap.git
cd php-bootstrap
composer install
```

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

## How To Contribute

### How To Add new route url
- add your new route in route collections
[https://github.com/harryosmar/php-bootstrap/blob/master/src/Route.php](https://github.com/harryosmar/php-bootstrap/blob/master/src/Routes.php)

### How To Add new console Task
- *Follow documentation* [here](https://symfony.com/doc/current/console.html) : how to create new console task
- add your console task file to this folder
[https://github.com/harryosmar/php-bootstrap/tree/master/src/console](https://github.com/harryosmar/php-bootstrap/tree/master/src/Console)
- then register your console task in [https://github.com/harryosmar/php-bootstrap/blob/master/src/Tasks.php](https://github.com/harryosmar/php-bootstrap/blob/master/src/Tasks.php)

## Unit Test
```
./vendor/bin/phpunit -c phpunit.xml  --debug
```


