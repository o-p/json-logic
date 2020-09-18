<?php
namespace JsonLogic\Operators;

use Closure;
use JsonLogic\Rule;
use JsonLogic\Support\Logical;

/**
 * @operator and
 */
class AndOperator extends Operator
{
    public function params($param): Closure
    {
        $subRules = array_map(
            [Rule::class, 'make'],
            $param
        );
        return function (&$data) use (&$subRules): bool {
            return array_reduce(
                $subRules,
                function ($logic, Closure $sub) use (&$data): bool {
                    return $logic && Logical::truthy(($sub)($data));
                },
                true
            );
        };
    }
}
