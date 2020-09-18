<?php
namespace JsonLogic\Operators;

use Closure;
use Countable;
use JsonLogic\Configurations;
use JsonLogic\Exceptions\InvalidOperatorParameter;
use JsonLogic\Validators\ParameterValidators;
use JsonLogic\Validators\Validator;

abstract class Operator
{
    use ParameterValidators;

    /** @var string the operator name in json-logic rules and displays in logs */
    protected $alias = '';
    /** @var int minimium parameter counts if the parameters accept array type, -1 is unlimited */
    protected $minParamCounts = -1;

    abstract public function params($params): Closure;

    public function specs(): Validator
    {
        return $this->any();
    }

    protected function autoValidateParams($params): void
    {
        // TODO - Refactor validators
        if (Configurations::get(Configurations::VALIDATE_PARAMETER_BEFORE_EXECUTION)) {
            $name = $this->alias ?: static::class;
            $min = $this->minParamCounts;
            $count = is_array($params) ? count($params) : -1;
            if ($min >= -1 && $count < $min) {
                throw new InvalidOperatorParameter(
                    sprintf(
                        'Operator [%s] expect to have at lease %d parameters, got %d',
                        $name,
                        $min,
                        $count
                    )
                );
            }
        }
    }
}
