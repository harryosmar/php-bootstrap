# links

- [Application Flow](#application-flow)
  - [Folder Structure](#folder-structure)
- [DI Container](#di-container)
- [Routing](#routing)
  - [Closure](#closure)
  - [Class Controller](#class-controller)
- [Middleware](#middleware)
- [Console](#console)
  - [How to add new console task](#how-to-add-new-console-task)


## Application Flow

`*` optional

```
public/index.php => App.php::handle => Routing::dispatch => *Middleware => Controller => *Middleware => Response
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

There is 2 type of Service Provider :
1. `CoreServiceProvider.php`. This only contained the common services like : `request`, `response`, `respose emitter`.
2. `src/ServiceProviders/`, add your new custom service here.

How To add new custom service.

For example We Have a controller named `HelloWorld`.

We want to use new service class `Hello` which provides function `sayHi()`.

So We create this file `src/Services/Hello.php`

```php
<?php
namespace PhpBootstrap\Services;

class Hello implements \PhpBootstrap\Contracts\Hello
{
    public function sayHi()
    {
        return 'Hello';
    }
}
```

Then Create custom service provider for controller `HelloWorld`.
at `src/ServiceProviders/Controller/HelloWorld.php`. In this file, You can add all services, needed to be available in controller `HelloWorld`, through the container.

```php
<?php
namespace PhpBootstrap\ServiceProviders\Controller;

use League\Container\ServiceProvider\AbstractServiceProvider;
use PhpBootstrap\Services\Hello;

class HelloWorld extends AbstractServiceProvider {

  protected $provides = [
      \PhpBootstrap\Contracts\Hello::class
  ];
  
  public function register() {
    $this->getContainer()
        ->add(\PhpBootstrap\Contracts\Hello::class, Hello::class);
  }
}
```

Later in `HelloWorld` controller, you can access service `Hello` from container.
```php
<?php
namespace PhpBootstrap\ServiceProviders\Controller;

use PhpBootstrap\Contracts\Response;
use Psr\Http\Message\ServerRequestInterface;

class HelloWorld extends Base {
  
  public function index(ServerRequestInterface $request, Response $response, array $args) {
    $hello = $this->container->get(PhpBootstrap\Contracts\Hello::class);
    return $response->withArray(
        [
            'message' => sprintf('%s %s', $hello->sayHi(), $args['name'])
        ],
        200
    );
  }
  
}
```