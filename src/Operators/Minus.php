<?php
namespace JsonLogic\Operators;

use Closure;
use JsonLogic\Parameters;

/**
 * @operator -
 */
class Minus extends Operator
{
    protected $alias = '-';

    public function params($param): Closure
    {
        $this->autoValidateParams($param);
        $prepared = Parameters::from($param);

        return function (&$data) use (&$prepared) {
            return $prepared->reduce(function ($a, $b) {
                return $a - $b;
            }, $data);
        };
    }
}
