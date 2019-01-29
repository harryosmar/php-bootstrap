# Guide Menus

- [Application Flow](#application-flow)
    - [Folder Structure](#folder-structure)
- [DI Container](#di-container)
    - [Custom Service Provider](#custom-service-provider)
- [Routing](#routing)
    - [Closure](#routing-closure)
    - [Class Controller](#routing-class-controller)
- [Middleware](#middleware)
- [Console](#console)
    - [Listing all console tasks](#listing-all-console-tasks)
    - [Run console task](#run-console-task)
    - [How to add new console task](#how-to-add-new-console-task)

## Application Flow

`*` optional

```
public/index.php => App.php::handle => Routing::dispatch => *Middleware:before => Controller => *Middleware:after => Response
```

- [`App.php`](https://github.com/harryosmar/php-bootstrap/blob/master/src/App.php) will register all services to the DI Container, and register all the routing paths.

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

1. [`CoreServiceProvider.php`](https://github.com/harryosmar/php-bootstrap/blob/master/src/CoreServiceProvider.php). This only contained the common services like : `request`, `response`, `respose emitter`.
2. [`src/ServiceProviders/`](https://github.com/harryosmar/php-bootstrap/tree/master/src/ServiceProviders), add your new custom service here.

### Custom Service Provider

> Question : How to add *new custom service provider*.

> Answer : Create new php class in [ServiceProviders DIR](https://github.com/harryosmar/php-bootstrap/tree/master/src/ServiceProviders) which extend `\League\Container\ServiceProvider\AbstractServiceProvider`

> Example : We Have a controller named [`HelloWorld`](https://github.com/harryosmar/php-bootstrap/blob/master/src/ServiceProviders/Controller/HelloWorld.php), inside this controller, we want to use service `Hello`. This `Hello` service is a PHP class, that we will retrieve from DI container. The objective is to use `Hello` service function `sayHi()`.  

> How to do it :


1. *create the service* : [`src/Services/Hello.php`](https://github.com/harryosmar/php-bootstrap/blob/master/src/Services/Hello.php)

2. *create the service provider* [`src/ServiceProviders/Controller/HelloWorld.php`](https://github.com/harryosmar/php-bootstrap/blob/master/src/ServiceProviders/Controller/HelloWorld.php)

3. *update the [routes](https://github.com/harryosmar/php-bootstrap/blob/master/src/Routes.php) file*. Add new service provider to DI `container`, before passed the `container` to `controller` constructor. See [example](#example-of-step-3).

4.  Later in [`HelloWorld` controller](https://github.com/harryosmar/php-bootstrap/blob/master/src/Controller/HelloWorld.php#L24), retrieve service [`Hello`](https://github.com/harryosmar/php-bootstrap/blob/master/src/Contracts/Hello.php) from container, then call `sayHi()` function. See [example](#example-of-step-4).

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

## Routing

All the route list define in [`Routes.php`](https://github.com/harryosmar/php-bootstrap/blob/master/src/Routes.php).

Currently there is 2 route groups :

1. Response content-type `applicationJSON` group. This group use middleware [`applicationJSON`](https://github.com/harryosmar/php-bootstrap/blob/master/src/Middleware/Response/applicationJSON.php).

2. Response content-type `text/html` group.  This group use middleware [`textHTML`](https://github.com/harryosmar/php-bootstrap/blob/master/src/Middleware/Response/textHTML.php).

### Routing Closure

```php
<?php
$route->map(
    'GET',
    '/',
    function (\Psr\Http\Message\ServerRequestInterface $request, \PhpBootstrap\Contracts\Response $response) {
        return $response->withArray(['Hello' => 'World']);
    }
);
```

### Routing Class Controller

```php
<?php
$route->map(
    'GET',
    '/hello/{name}',
    [
        new \PhpBootstrap\Controller\HelloWorld($container),
        'sayHi'
    ]
);
```

## Middleware

Middleware should be put in this [src/Middleware](https://github.com/harryosmar/php-bootstrap/tree/master/src/Middleware) DIR.

Middleware is used in routing dispatching process. By using middleware, we can define logic(eg: modify request, response) that needed to be executed,  *before* or *after* the application process.

Example :

We have this [`DummyTokenChecker`](https://github.com/harryosmar/php-bootstrap/blob/master/src/Middleware/DummyTokenChecker.php), which validate the request `uri` must contained `access_token` key.

```
URL?access_token=abcdef
```

If `access_token` is not provided in the `uri`, then it will return `errorUnauthorized` `401` response.

```json
{
    "error":
    {
        "http_code": 401,
        "phrase": "Unauthorized"
    }
}
```

If valid, then the request will be continued to the [`HelloWorld`](https://github.com/harryosmar/php-bootstrap/blob/master/src/Controller/HelloWorld.php) controller.

How the [Route]((https://github.com/harryosmar/php-bootstrap/blob/master/src/Routes.php)) code looks like.

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
)->middleware(new \PhpBootstrap\Middleware\DummyTokenChecker());
```

## Console

### listing all console tasks

```
php console.php list
```

### Run console task

example : run [`app:helloworld`](https://github.com/harryosmar/php-bootstrap/blob/master/src/Console/HelloWorld.php) task.

```
php console.php app:helloworld
```

### How to add new console task

1. Create new console task example [`HelloWorld.php`](https://github.com/harryosmar/php-bootstrap/blob/master/src/Console/HelloWorld.php). This class must `extends` `\Symfony\Component\Console\Command\Command`.

2. Add this new console task to the [`tasks list`](https://github.com/harryosmar/php-bootstrap/blob/master/src/Tasks.php)

```php
 $application->add(new \PhpBootstrap\Console\HelloWorld());
```
