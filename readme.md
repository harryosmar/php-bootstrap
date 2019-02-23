# Swagger openapi 3.0 Example

* [Swagger.io Screenshot](#swagger.io-screenshot)
* [Yaml Content](#yaml-content)
* [How To Build](#how-to-build)
  * [Console](#console)
  * [Composer](#composer)
* [How To Validate yml content](#how-to-validate-yml-content)
* [Links](#links)

## Swagger.io Screenshot

![swagger.io screenshot](https://github.com/harryosmar/php-bootstrap/blob/swagger/public/images/swagger.io-v2.png)

## Yaml Content

```yaml
openapi: 3.0.0
info:
  title: Example
  version: '0.1'
paths:
  /:
    get:
      responses:
        '404':
          description: 'Page not found'
  /books:
    get:
      responses:
        '200':
          description: 'list of books'
          content:
            application/json:
              schema:
                $ref: '#/components/schemas/Books'
  /validation:
    post:
      responses:
        '200':
          description: 'Validation using evaluator'
          content:
            application/json:
              schema:
                $ref: '#/components/schemas/EvaluatorResult'
components:
  schemas:
    Book:
      properties:
        title:
          description: 'The book title'
          type: string
        price:
          description: 'The price'
          type: number
          format: float
        published_year:
          description: 'The published year'
          type: integer
        author:
          $ref: '#/components/schemas/BookAuthor'
      type: object
    BookAuthor:
      properties:
        name:
          description: 'The author name'
          type: string
        email:
          description: 'The author email'
          type: string
      type: object
    Books:
      properties:
        data:
          description: 'List of Book'
          items:
            $ref: '#/components/schemas/Book'
      type: object
    EvaluatorResult:
      properties:
        status:
          description: 'The status'
          type: boolean
        failureTags:
          description: 'The failure tags'
          type: array
          items:
            type: string
      type: object
```


## How To Build 

### Console

command
```
php console.php app:open.api.doc:generate
```

output of complete `openapi yml` will be displayed in console. Output should be like [this](#yaml-content).

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
2. Then replace the swaggerEditor content with the content of `openapi.yaml` file. The result should be like [this](##swaggerio-screenshot).

## Links
- https://github.com/zircote/swagger-php/blob/master/README.md
- http://zircote.com/swagger-php/Getting-started.html
