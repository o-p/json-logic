<?php
namespace JsonLogic\Validators;

use JsonLogic\Exceptions\InvalidOperatorParameter;

class Validator
{
    protected $specs;

    public function __construct(...$specs)
    {
        $this->specs = $specs;
    }

    public function test($param): bool
    {
        return true;
    }

    protected function throwException($key, $path, $tag, $expect, $value)
    {
        throw new InvalidOperatorParameter(
            sprintf(
                'The parameter to the operator %s expect to be %s, got %s. (%s)',
                $tag,
                $expect,
                $value,
                $path
            )
        );
    }
}
