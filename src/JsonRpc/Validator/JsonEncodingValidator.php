<?php
namespace JsonRpc\Validator;

use JsonRpc\Validator\Validator;
use JsonRpc\Exception\JsonEncodingFailureException;

class JsonEncodingValidator extends Validator
{
    public static function validate($jsonLastError)
    {
        if ($jsonLastError !== JSON_ERROR_NONE) {
            switch ($jsonLastError) {
                case JSON_ERROR_DEPTH:
                    $errorMessage = 'The maximum stack depth has been exceeded';
                    break;
                case JSON_ERROR_STATE_MISMATCH:
                    $errorMessage = '	Invalid or malformed JSON';
                    break;
                case JSON_ERROR_CTRL_CHAR:
                    $errorMessage = 'Control character error, possibly incorrectly encoded';
                    break;
                case JSON_ERROR_SYNTAX:
                    $errorMessage = 'Syntax error';
                    break;
                case JSON_ERROR_UTF8:
                    $errorMessage = 'Malformed UTF-8 characters, possibly incorrectly encoded';
                    break;
                case JSON_ERROR_RECURSION:
                    $errorMessage = 'One or more recursive references in the value to be encoded';
                    break;
                case JSON_ERROR_RECURSION:
                    $errorMessage = 'One or more NAN or INF values in the value to be encoded';
                    break;
                case JSON_ERROR_UNSUPPORTED_TYPE:
                    $errorMessage = 'A value of a type that cannot be encoded was given';
                    break;
                default:
                    $errorMessage = 'Unknown error';
                    break;
            }

            throw new JsonEncodingFailureException($errorMessage, $jsonLastError);
        }
    }
}