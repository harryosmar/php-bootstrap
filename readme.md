# JWT Server example

## Requirements
- php >= 7.0
- composer https://getcomposer.org/download/

## How To Setup
```
git clone --single-branch --branch jwt-server git@github.com:harryosmar/php-bootstrap.git jwt-server
cd jwt-server
composer install
```

## How To Use
- Start the web dev server in `http://localhost:8000/`
```
php -S localhost:8000 -t public
```

- Hit the `POST /token` endpoint to create the `JWT` token
Request
```
curl -X POST \
  'http://localhost:8000/token' \
  -H 'Content-Type: application/x-www-form-urlencoded' \
  -H 'cache-control: no-cache' \
  -d 'client_id=1&audience=http%3A%2F%2Fclient1.com&data%5Bsomekey%5D=somevalue'
```
Response
```json
{
    "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9leGFtcGxlLmNvbSIsImF1ZCI6Imh0dHA6XC9cL2NsaWVudDEuY29tIiwiaWF0IjoxNTQ5MjI3OTg0LCJjbGllbnRfaWQiOiIxIiwic29tZWtleSI6InNvbWV2YWx1ZSJ9.OPPXiABj4FoZRwKvY9QnpswqRVnD37o0TbDNsO5hO13parGYgEHfa_dzw7SDsSZtjLMoHd6akWhnTRRO31ma1OJKkR5HllSGeFbTNWKs6NYbn2j6wzYbC_3gm65zhnGgeYw85Na_CrXC220m4yTuFH9JbNrba0UBdjZYQfRoVNw"
}
```
Link to Validate the token : [jwt-debug for token above](https://jwt.io/#debugger-io?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9leGFtcGxlLmNvbSIsImF1ZCI6Imh0dHA6XC9cL2NsaWVudDEuY29tIiwiaWF0IjoxNTQ5MjI3OTg0LCJjbGllbnRfaWQiOiIxIiwic29tZWtleSI6InNvbWV2YWx1ZSJ9.OPPXiABj4FoZRwKvY9QnpswqRVnD37o0TbDNsO5hO13parGYgEHfa_dzw7SDsSZtjLMoHd6akWhnTRRO31ma1OJKkR5HllSGeFbTNWKs6NYbn2j6wzYbC_3gm65zhnGgeYw85Na_CrXC220m4yTuFH9JbNrba0UBdjZYQfRoVNw&publicKey=-----BEGIN%20PUBLIC%20KEY-----%0AMIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDdlatRjRjogo3WojgGHFHYLugd%0AUWAY9iR3fy4arWNA1KoS8kVw33cJibXr8bvwUAUparCwlvdbH6dvEOfou0%2FgCFQs%0AHUfQrSDv%2BMuSUMAe8jzKE4qW%2BjK%2BxQU9a03GUnKHkkle%2BQ0pX%2Fg6jXZ7r1%2FxAK5D%0Ao2kQ%2BX5xK9cipRgEKwIDAQAB%0A-----END%20PUBLIC%20KEY-----)

> This JWT server use `"alg": "RS256"`, which need `private` & `public` key for encryption.

RSA Keys :
- Private [1.id_rsa](https://github.com/harryosmar/php-bootstrap/blob/jwt-server/keys/1.id_rsa)
- Public [1.id_rsa.pub](https://github.com/harryosmar/php-bootstrap/blob/jwt-server/keys/1.id_rsa.pub)

> `1` : is the `client_id`, which need to be passed in request body. Right now only client_id `1` is handled in this JWT server.


Check this file [TokenTest.php](https://github.com/harryosmar/php-bootstrap/blob/jwt-server/tests/unit/TokenTest.php) on how to :
- `generate token`,
- `validate token data` and 
- `validate signature`


## How To Run The Test
```
composer test
```
