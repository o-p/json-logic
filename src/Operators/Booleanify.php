<?php
namespace JsonLogic\Operators;

use Closure;
use JsonLogic\Rule;
use JsonLogic\Support\Logical;

use function is_array;

/**
 * @operator !!
 */
class Booleanify extends Operator
{
    protected $alias = '!!';

    public function params($params): Closure
    {
        $sub = !is_array($params) || Rule::isValid($params)
            ? Rule::make($params)
            : Rule::make($params[0] ?? $params);

        return function (&$data) use (&$sub) {
            return Logical::truthy($sub($data));
        };
    }
}
