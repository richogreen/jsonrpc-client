# Simple PHP JSON-RPC Client

Straight forward JSON RPC 2.0 Client for PHP without the bloat.

See JSON-RPC spec for more info:
http://www.jsonrpc.org/specification

### Composer

```
composer require r-green/jsonrpc-client
```

### Usage

```
use JsonRpc\Client;

$params = [
    ...
];

$client = new Client('http://www.example.com');
$client->request(123456, 'myMethod', $params); // ID, Method, Params

$result = $client->send();
```

