<?php
namespace Tests\JsonLogic\Operators;

use JsonLogic\Operators\AndOperator;
use Tests\TestCase;

/**
 * @group operators
 */
class AndOperatorTest extends TestCase
{
    /** @dataProvider cases */
    public function test($arguments, $data, $expect): void
    {
        $this->assertSame(
            $expect,
            (new AndOperator())->params($arguments)($data)
        );
    }

    public function cases(): array
    {
        return [
            'Flatten, multiple types, only truthy values' => [
                ['truthy', true, 123, ['0']],
                null,
                true,
            ],
            'Flatten, multiple types, with falsy value' => [
                ['truthy', true, 0, ['0']],
                null,
                false,
            ],
            'Nested case, only truthy' => [
                [
                    ['and' => [
                        ['and' => [1, 1]],
                        ['and' => [1, 2, 3]],
                    ]],
                    ['and' => ['a', 'b', 'c']],
                    true,
                ],
                null,
                true,
            ],
            'Nested case, with falsy' => [
                [
                    ['and' => [
                        ['and' => [1, 1]],
                        ['and' => [1, 2, 3]],
                    ]],
                    ['and' => ['a', 'b', '']],
                    true,
                ],
                null,
                false,
            ],
            'Complex case with variable, only truthy' => [
                [
                    ['and' => [
                        ['var' => ['a']],
                        ['and' => [1, 2, ['var' => 'b']]],
                    ]],
                    ['var' => ['not-exist', 100]],
                    true,
                ],
                ['a' => 100, 'b' => true],
                true,
            ],
            'Complex case with variable, contain falsy' => [
                [
                    ['and' => [
                        ['var' => ['a']],
                        ['and' => [1, 2, ['var' => 'b']]],
                    ]],
                    ['var' => ['not-exist', 0]],
                    true,
                ],
                ['a' => 100, 'b' => true],
                false,
            ],
        ];
    }
}
