<?php
/**
 * Created by PhpStorm.
 * User: richardgreen
 * Date: 3/10/2016
 * Time: 9:48 AM
 */

namespace JsonRpc\Validator;

abstract class Validator
{
    abstract protected static function validate($value);
}