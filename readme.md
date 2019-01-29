# PHP VRP Engine Server

## Requirements
- docker
- docker-compose

## How To Setup
```
git clone git@git.csnzoo.com:hs040x/php-vrp-engine-server.git
cd php-vrp-engine-server
composer install
docker-compose up
```

Then open `http://localhost:8080/`

## How To Use

Request 

```
curl -X POST \
  http://localhost:8080/validation \
  -H 'Content-Type: application/x-www-form-urlencoded' \
  -H 'cache-control: no-cache' \
  -d 'lead_time=1'
```

Response

```json
{
    "status": false,
    "failure_tags": [
        "TEXT_IS_NOT_BLANK",
        "IS_DIGIT",
        "INVALID_LEAD_TIME"
    ]
}
```

## How To Contribute
- Fork this repo
- post an issue https://github.com/harryosmar/php-bootstrap/issues
- create the PR(Pull Request) and wait for the review

