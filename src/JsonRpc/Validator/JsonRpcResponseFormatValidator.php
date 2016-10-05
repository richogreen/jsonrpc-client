<?php
/**
 * Author: Richard Green
 * Date: 28/09/2016
 * Time: 4:04 PM
 */

namespace JsonRpc\Validator;

use JsonRpc\Validator\Validator;
use JsonRpc\Exception\JsonRpcFormatInvalidException;

class JsonRpcResponseFormatValidator extends Validator
{
    public function validate($response)
    {
        if (!isset($response['jsonrpc']) || $response['jsonrpc'] !== '2.0' && (!isset($response['result']) || !isset($response['error'])) || !isset
            ($response['id'])) {
            throw new JsonRpcFormatInvalidException('Invalid JSON-RPC response format');
        }

        if (isset($response['result']) && !is_array($response['result'])) {
            throw new JsonRpcFormatInvalidException('Invalid JSON-RPC response format');
        }

        if (isset($response['error'])) {
            if (is_array($response['error']) && isset($response['error']['message'])) {
                throw new JsonRpcFormatInvalidException($response['error']['message']);
            }

            throw new JsonRpcFormatInvalidException('Invalid JSON-RPC error');
        }
    }
}