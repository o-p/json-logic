<?php
namespace JsonLogic\Operators;

use Closure;

class Identity extends Operator
{
    public static function of($value): Closure
    {
        return (new static)->params($value);
    }

    public function params($params): Closure
    {
        return function () use ($params) {
            return $params;
        };
    }
}
