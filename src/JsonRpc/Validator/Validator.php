<?php
/**
 * Author: Richard Green
 * Date: 28/09/2016
 * Time: 4:04 PM
 */

namespace JsonRpc\Validator;

abstract class Validator
{
    abstract protected static function validate($value);
}