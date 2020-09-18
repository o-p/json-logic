<?php
namespace Tests\JsonLogic;

use Tests\TestCase;
use JsonLogic\Rule;
use Closure;

class RuleTest extends TestCase
{
    /** @dataProvider logics */
    public function testMake($rule): void
    {
        $this->assertInstanceOf(
            Closure::class,
            Rule::make($rule)
        );
    }

    public function logics(): array
    {
        return [
            'Valid rule' => [
                ['var' => ['path.to.property', 'default']],
            ],
            'Rule operator not registered' => [
                ['__UNKNOWN__OPERATOR__' => []],
            ],
            'Not rule' => [
                null,
            ],
        ];
    }
}
