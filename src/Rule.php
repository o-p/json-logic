<?php
namespace JsonLogic;

use Closure;
use JsonLogic\JsonLogic;
use JsonLogic\Operators\Identity;

use function count;
use function is_array;
use function is_string;

class Rule
{
    /** @var mixed */
    private $rule;
    /** @var Closure|null */
    private $compiled;

    /**
     * Test if rule is valid,
     * the default mode (non-strict) is same as official JsonLogic::is_logic
     */
    public static function isValid($rule, $strict = false): bool
    {
        return $strict
            ? is_array($rule) && JsonLogic::isValidOperatorKeyword((string) static::getOperatorKeyword($rule))
            : is_array($rule) && count($rule) === 1 && is_string(static::getOperatorKeyword($rule));
    }

    /** @return int|string|null */
    public static function getOperatorKeyword(array $rule)
    {
        foreach ($rule as $op => $params) {
            return $op;
        }

        return null;
    }

    public static function make($input): Closure
    {
        return static::isValid($input, true)
            ? static::from($input)
            : Identity::of($input);
    }

    public static function from(array $rule): Closure
    {
        $keyword = static::getOperatorKeyword($rule);
        $params = $rule[$keyword];
        return JsonLogic::operators()->get($keyword)->params($params);
    }


    public function __construct(array $rule)
    {
        $this->rule = $rule;
    }

    public function compile(): self
    {
        $this->compiled = static::make($this->rule);
        return $this;
    }

    public function process($feed)
    {
        return $this->getCompiledRule()($feed);
    }

    protected function getCompiledRule(): Closure
    {
        return $this->compiled ?: $this->compile()->getCompiledRule();
    }
}
