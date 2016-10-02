<?php
/**
 * Author: Richard Green
 * Date: 28/09/2016
 * Time: 4:04 PM
 */

require_once __DIR__.'/../vendor/autoload.php';

use JsonRpc\Client;

$url = 'https://dev-dataconnect.givex.com:50104';

$params = [
    "en",
    "TC_000001",
    "30424",
    "2728",
    "PARTNER_1",
    "Richard Green",
    "rg@ie.com.au",
    "50.00",
    [[
        "SHIP_000001",
        "Luc Houselander",
        "lh@rg.com.au",
        "2017-10-28",
        [[
            "OEF_000001-1",
            "887766",
            "1",
            "50.00",
            [[
                "Luc Houselander",
                "IE Digital",
                "This is a test message!"
            ]]
        ]],
        "2016-10-27",
        "email"
    ]]
];


$client = new Client($url);
$client->request('123456', '956', $params);
$result = $client->send();

print_r($result);
die;