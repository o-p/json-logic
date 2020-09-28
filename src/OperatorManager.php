<?php
namespace JsonLogic;

use JsonLogic\Operators\Operator;

class OperatorManager
{
    protected $operators = [];

    public function __construct(array $extras = [])
    {
        foreach (array_replace($this->buildins(), $this->customs(), $extras) as $keyword => $op) {
            if ($op instanceof Operator) {
                $this->register($keyword, $op);
            } elseif (class_exists($op)) {
                $this->register($keyword, new $op);
            }
        }
    }

    public function register(string $keyword, Operator $op): void
    {
        $this->operators[$keyword] = $op;
    }

    public function get(string $keyword = ''): ?Operator
    {
        return $this->operators[$keyword] ?? null;
    }

    protected function buildins(): array
    {
        return [
            // Accessing Data
            'var' => Operators\VarOperator::class,
            'missing' => null,
            'missing_some' => null,
            // Logic and Boolean Operations
            'if' => null,
            '==' => Operators\Equal::class,
            '===' => Operators\Identical::class,
            '!=' => Operators\NotEqual::class,
            '!==' => Operators\NotIdentical::class,
            '!' => Operators\Not::class,
            '!!' => Operators\Booleanify::class,
            'or' => Operators\OrOperator::class,
            'and' => Operators\AndOperator::class,
            // Numeric Operations
            '>' => Operators\GreaterThan::class,
            '>=' => Operators\GreaterThanOrEqual::class,
            '<' => Operators\LessThan::class,
            '<=' => Operators\LessThanOrEqual::class,
            'max' => null,
            'min' => null,
            '+' => Operators\Plus::class,
            '-' => Operators\Minus::class,
            '*' => Operators\Multiply::class,
            '/' => Operators\Divide::class,
            '%' => Operators\Modulo::class,
            // Array Operations
            'map' => null,
            'reduce' => null,
            'filter' => null,
            'all' => null,
            'none' => null,
            'some' => null,
            'merge' => null,
            'in' => null,
            // String Operations
            'in' => null,
            'cat' => null,
            'substr' => null,
            // Miscellaneous
            'log' => null,
        ];
    }

    protected function customs(): array
    {
        return [];
    }
}
