<h1 align="center">Pay.nl API client for PHP</h1>

> > This SDK is NOT production ready yet. Please do not use it in production.

Unofficial PHP SDK for the Pay.nl API.


## Installation

```
$ composer require imbue/paynl-api-php
```

## Getting started

Initialize the Pay.nl API client

```php
$paynlClient = new PaynlClient();
$paynlClient->setAuth('your-at-code', 'your-api-token');
$paynlClient->setSlCode('your-service-location-code');
```
