# Swagger openapi 3.0 Example

* [How To Build](#how-to-build)
  * [Console](#console)
  * [Composer](#composer)

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