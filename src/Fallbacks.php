<?php
namespace JsonLogic;

use JsonLogic\Operators\CallableOperator;
use JsonLogic\Rule;
use JsonLogic\Support\Logical;

use function array_keys;
use function array_merge;
use function array_unique;
use function count;
use function is_array;
use function is_numeric;
use function is_string;

/**
 * For fully fallback to official JsonLogic lib
 */
trait Fallbacks
{
    /** @deprecated 1.0.0 */
    public static function get_operator($logic)
    {
        return array_keys($logic)[0];
    }

    /** @deprecated 1.0.0 */
    public static function get_values($logic, $fix_unary = true)
    {
        $op = static::get_operator($logic);
        $values = $logic[$op];

        if ($fix_unary && (!is_array($values) or static::is_logic($values))) {
            $values = [ $values ];
        }
        return $values;
    }

    /** @deprecated 1.0.0 */
    public static function is_logic($array): bool
    {
        return Rule::isValid($array);
    }

    /** @deprecated 1.0.0 */
    public static function truthy($logic): bool
    {
        return Logical::truthy($logic);
    }

    /** @deprecated 1.0.0 */
    public static function uses_data($logic): array
    {
        if (is_object($logic)) {
            $logic = (array) $logic;
        }

        $collection = [];

        if (self::is_logic($logic)) {
            $op = array_keys($logic)[0];
            $values = (array) $logic[$op];

            if ($op === 'var') {
                $collection[] = $values[0];
            } else {
                foreach ($values as $value) {
                    $collection = array_merge($collection, self::uses_data($value));
                }
            }
        }

        return array_unique($collection);
    }

    /** @deprecated 1.0.0 */
    public static function rule_like($rule, $pattern): bool
    {
        if (is_string($pattern) and $pattern[0] === '{') {
            $pattern = json_decode($pattern, true);
        }

        switch ($pattern) {
            case $rule:
            case '@':
                return true;
            case 'number':
                return is_numeric($rule);
            case 'string':
                return is_string($rule);
            case 'array':
                return is_array($rule) && !static::is_logic($rule);
            default:
                if (static::is_logic($pattern) && static::is_logic($rule)) {
                    $patternOp = static::get_operator($pattern);
                    if ($patternOp === '@' || $patternOp === static::get_operator($rule)) {
                        return static::rule_like(
                            static::get_values($rule, false),
                            static::get_values($pattern, false)
                        );
                    }
                }
                return is_array($pattern)
                    && is_array($rule)
                    && count($pattern) === count($rule)
                    && !in_array(false, array_map('static::rule_like', $pattern, $rule));
        }
    }

    /** @deprecated 1.0.0 */
    public static function add_operation(string $name, callable $callable): void
    {
        JsonLogic::operators()->register(
            $name,
            new CallableOperator($callable)
        );
    }
}
