<?php
namespace JsonLogic;

class JsonLogic
{
    use Fallbacks;

    /** @var \JsonLogic\OperatorManager */
    protected static $manager;

    public static function apply($rule, $data)
    {
        return static::rule($rule)->process($data);
    }

    public static function rule($rule): Rule
    {
        switch (gettype($rule)) {
            case 'string':
                return new Rule(json_decode($rule, true) ?: []);
            case 'array':
                return new Rule($rule);
            case 'object':
                return new Rule((array) $rule);
        }
        return (new Rule($rule))->compile();
    }

    public static function setOperators($operators): void
    {
        static::$manager = $operators instanceof OperatorManager
            ? $operators
            : new OperatorManager($operators);
    }

    public static function operators(): OperatorManager
    {
        if (!static::$manager) {
            static::setOperators([]);
        }
        return static::$manager;
    }

    public static function isValidOperatorKeyword(string $key): bool
    {
        return static::operators()->get($key) instanceof Operators\Operator;
    }
}
