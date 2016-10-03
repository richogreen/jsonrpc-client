# Simple PHP JSON-RPC Client

Basic Client for JSON-RPC 2.0
http://www.jsonrpc.org/specification

### Composer

```
composer require r-green/jsonrpc-client
```

### Usage

```
use JsonRpc\Client;

$params = [];

$client = new Client('http://www.example.com');
// ID, Method, Params
$client->request(123456, 'myMethod', $params); 

$result = $client->send();
```

