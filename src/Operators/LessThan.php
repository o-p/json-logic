<?php
namespace JsonLogic\Operators;

use Closure;
use JsonLogic\Parameters;

/**
 * @operator <
 */
class LessThan extends Operator
{
    protected $alias = '<';
    protected $minParamCounts = 2;

    public function params($param): Closure
    {
        $this->autoValidateParams($param);
        $prepared = Parameters::from($param);

        return function (&$data) use (&$prepared): bool {
            return $prepared->everyPairs(function (&$a, &$b) {
                return $a < $b;
            }, $data);
        };
    }
}
