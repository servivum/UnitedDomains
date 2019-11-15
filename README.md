# United Domains PHP Client Library 

A convenient tool to use United Domains API. It provides tools for direct API calls and convenient wrappers.

## Installation

This fork can currently only be installed via github.

```
composer require hades-architect/united-domains
```

## Usage

### Client

```php
$client = new \HadesArchitect\UnitedDomains\Client($username, $password);

$response = $client->checkDomain([
                'domain' => 'example.com',
            ]);

echo $response;
```

### Traceable Client 

It brings more output if you debug something.

```php
// Client
$client = new \HadesArchitect\UnitedDomains\TraceableClient($username, $password);
// Logger 
$client->setLogger(
    new \Monolog\Logger(
        'ud_api',
        [new \Monolog\Handler\StreamHandler('php://stdout', \Monolog\Logger::DEBUG)],
        [new \Monolog\Processor\PsrLogMessageProcessor()]
    )
);
$client->enableDebug();
$response = $client->call('CheckDomain', ['domain' => 'example.com']);
echo $response;
```

## Todo

- [ ] More tests
