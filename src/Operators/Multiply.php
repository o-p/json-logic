<?php
namespace JsonLogic\Operators;

use Closure;
use JsonLogic\Parameters;

/**
 * @operator *
 */
class Multiply extends Operator
{
    protected $alias = '*';

    public function params($param): Closure
    {
        $this->autoValidateParams($param);
        $prepared = Parameters::from($param);

        return function (&$data) use (&$prepared) {
            return array_product($prepared->values($data));
        };
    }
}
