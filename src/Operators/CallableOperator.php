<?php
namespace JsonLogic\Operators;

use Closure;

class CallableOperator extends Operator
{
    private $callable;

    public function __construct(callable $callable)
    {
        $this->callable = $callable;
    }

    public function params($params): Closure
    {
        $callable = $this->callable;
        return function ($data) use ($callable, $params) {
            return $callable($params, $data);
        };
    }
}
