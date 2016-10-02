<?php

namespace JsonRpc\Validator;

use JsonRpc\Validator\Validator;
use JsonRpc\Exception\JsonRpcFormatInvalidException;

class JsonRpcFormatValidator extends Validator
{
    public static function validate($payload)
    {
        if (!isset($payload['jsonrpc']) || !isset($payload['method']) || !is_string($payload['method']) || $payload['jsonrpc'] !== '2.0'
            || (isset($payload['params']) && !is_array($payload['params']))) {

            throw new JsonRpcFormatInvalidException('Invalid JSON-RPC format');
        }
    }
}