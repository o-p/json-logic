<?php
namespace Tests\JsonLogic\Operators;

use JsonLogic\Operators\OrOperator;
use Tests\TestCase;

/**
 * @group operators
 */
class OrOperatorTest extends TestCase
{
    /** @dataProvider cases */
    public function test($arguments, $data, $expect): void
    {
        $this->assertSame(
            $expect,
            (new OrOperator())->params($arguments)($data)
        );
    }

    public function cases(): array
    {
        return [
            'Flatten, multiple types, only falsy values' => [
                ['', false, 0, null],
                null,
                false,
            ],
            'Flatten, multiple types, with true value' => [
                ['', false, 0, ['0'], null],
                null,
                true,
            ],
            'Nested case, only falsy' => [
                [
                    ['or' => [
                        ['or' => [null, 0]],
                        ['or' => [0, false, '']],
                    ]],
                    ['or' => ['', 0, null]],
                    false,
                ],
                null,
                false,
            ],
            'Nested case, with truthy' => [
                [
                    ['or' => [
                        ['or' => [null, 0]],
                        ['or' => [0, false, '123']],
                    ]],
                    ['or' => ['', 0, null]],
                    false,
                ],
                null,
                true,
            ],
            'Complex case with variable, only falsy' => [
                [
                    ['or' => [
                        ['var' => ['a']],
                        ['or' => [false, 0, ['var' => 'b']]],
                    ]],
                    ['var' => ['not-exist', 0]],
                    null,
                ],
                ['a' => 0, 'b' => false],
                false,
            ],
            'Complex case with variable, contain truthy' => [
                [
                    ['or' => [
                        ['var' => ['a']],
                        ['or' => [false, 0, ['var' => 'b']]],
                    ]],
                    ['var' => ['not-exist', 0]],
                    null,
                ],
                ['a' => 0, 'b' => true],
                true,
            ],
        ];
    }
}
