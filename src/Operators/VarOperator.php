<?php
namespace JsonLogic\Operators;

use Closure;

use function array_reduce;
use function explode;
use function is_string;

/**
 * @example { "var": ["path.to.property"] }
 * @example { "var": ["path.to.property", "OPTIONAL_DEFAULT"] }
 * @example { "var": "syntax.sugar" }
 *
 * @operator var
 */
class VarOperator extends Operator
{
    const DELIMETER = '.';

    protected $alias = 'var';
    protected $minParamCounts = 1;

    public function params($params): Closure
    {
        if (is_string($params)) {
            return $this->params([$params]);
        }
        $this->autoValidateParams($params);
        $route = explode(static::DELIMETER, (string) $params[0]);
        $default = $params[1] ?? null;

        return function (&$data) use (&$route, &$default) {
            return array_reduce(
                $route,
                function (&$current, &$key) use (&$default) {
                    return $current[$key] ?? $default;
                },
                $data
            );
        };
    }
}
