# links

- [Application Flow](#application-flow)
    - [Folder Structure](#folder-structure)
- [DI Container](#di-container)
    - [Custom Service Provider](#Custom Service Provider)
- [Routing](#routing)
    - [Closure](#closure)
    - [Class Controller](#class-controller)
- [Middleware](#middleware)
- [Console](#console)
    - [How to add new console task](#how-to-add-new-console-task)


## Application Flow

`*` optional

```
public/index.php => App.php::handle => Routing::dispatch => *Middleware:before => Controller => *Middleware:after => Response
```

- `App.php` will register all services to the DI Container, and register all the routing paths.

### Folder Structure

```
public/
  index.php
src/
  Console/
  Controller/
  Middleware/
  ServiceProviders/
  App.php
  CoreServiceProvider.php
  Routes.php
  Tasks.php
```


## DI Container

There is 2 types of *Service Provider* :

1. `CoreServiceProvider.php`. This only contained the common services like : `request`, `response`, `respose emitter`.
2. `src/ServiceProviders/`, add your new custom service here.

### Custom Service Provider

> Question : How to add *new custom service provider*.

> Answer : Create new php class in [ServiceProviders DIR](https://github.com/harryosmar/php-bootstrap/tree/master/src/ServiceProviders) which extend `\League\Container\ServiceProvider\AbstractServiceProvider`

> Example : We Have a controller named [`HelloWorld`](https://github.com/harryosmar/php-bootstrap/blob/master/src/ServiceProviders/Controller/HelloWorld.php), inside this controller, we want to use service `Hello`. This `Hello` service is a PHP class, that we will retrieve from DI container. The objective is to use `Hello` service function `sayHi()`.  

> How to do it


1. *create the service* : [`src/Services/Hello.php`](https://github.com/harryosmar/php-bootstrap/blob/master/src/Services/Hello.php)

2. *create the service provider* [`src/ServiceProviders/Controller/HelloWorld.php`](https://github.com/harryosmar/php-bootstrap/blob/master/src/ServiceProviders/Controller/HelloWorld.php)

3. *update the [routes](https://github.com/harryosmar/php-bootstrap/blob/master/src/Routes.php) file*. Add new service provider to DI `container` before passed it to `controller` constructor. See [example](#example-of-step-3).

4.  Later in [`HelloWorld` controller](https://github.com/harryosmar/php-bootstrap/blob/master/src/Controller/HelloWorld.php#L24), retrieve service [`Hello`](https://github.com/harryosmar/php-bootstrap/blob/master/src/Contracts/Hello.php) from container, then call `sayHi()` function. See [example](#example-of-step-4)

###### example of step 3
```php
<?php
$route->map(
'GET',
'/hello/{name}',
  [
      new \PhpBootstrap\Controller\HelloWorld(
          $container->addServiceProvider(new \PhpBootstrap\ServiceProviders\Controller\HelloWorld)
      ),
      'sayHi'
  ]
);
```

###### example of step 4

```php
<?php
$hello = $this->container->get(\PhpBootstrap\Contracts\Hello::class);
$hello->sayHi();
```