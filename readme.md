# Swagger openapi 3.0 Example

* [How To Build](#how-to-build)
  * [Console](#console)
  * [Composer](#composer)
* [How To Validate yml content](#how-to-validate-yml-content)
* [Links](#links)

## How To Build 

### Console

command
```
php console.php app:open.api.doc:generate
```

output of complete `openapi yml` will be displayed in console.

### Composer

command
```
composer openapi
```

output
```
> ./vendor/bin/openapi --output openapi.yaml src
```

This will create `openapi.yaml` in root directory.

## How To Validate yml content

1. Goto `https://editor.swagger.io/`
2. Then replace the swaggerEditor content with the content of `openapi.yaml` file.

## Links
- https://github.com/zircote/swagger-php/blob/master/README.md
- http://zircote.com/swagger-php/Getting-started.html