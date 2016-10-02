<?php
namespace JsonRpc\Validator;

use JsonRpc\Validator\Validator;
use JsonRpc\Exception\InvalidJsonFormatException;

class JsonFormatValidator extends Validator
{
    public static function validate($payload)
    {
        if (!is_array($payload)) {
            throw new InvalidJsonFormatException('Invalid JSON payload');
        }
    }
}