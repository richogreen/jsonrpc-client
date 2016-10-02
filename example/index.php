<?php
/**
 * Author: Richard Green
 * Date: 28/09/2016
 * Time: 4:04 PM
 */

require_once __DIR__.'/../vendor/autoload.php';

use JsonRpc\Client;

$id = '';
$method = '';
$url = '';

$params = [];


$client = new Client($url);
$client->request($id, $method, $params);
$result = $client->send();

print_r($result);
die;