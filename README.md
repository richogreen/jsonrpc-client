# Simple PHP JSON-RPC Client

### Usage

```
use JsonRpc\Client;

$client = new Client($url);
$client->request($id, $method, $params);
$result = $client->send();
```

