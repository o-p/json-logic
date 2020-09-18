<?php
namespace JsonLogic\Validators;

// TODO: arrayOf, oneOf, subRule, fixedValue
trait ParameterValidators
{
    protected function any(): Validator
    {
        return new Validator();
    }
}
