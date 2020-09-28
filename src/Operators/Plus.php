<?php
namespace JsonLogic\Operators;

use Closure;
use JsonLogic\Parameters;

/**
 * @operator +
 */
class Plus extends Operator
{
    protected $alias = '+';

    public function params($param): Closure
    {
        $this->autoValidateParams($param);
        $prepared = Parameters::from($param);

        return function (&$data) use (&$prepared) {
            return array_sum($prepared->values($data));
        };
    }
}
