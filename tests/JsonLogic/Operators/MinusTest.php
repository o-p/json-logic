<?php
namespace Tests\JsonLogic\Operators;

use JsonLogic\Operators\Minus;
use Tests\TestCase;

use function number_format;

/**
 * @group operators
 */
class MinusTest extends TestCase
{
    /** @dataProvider cases */
    public function test(array $params, $data, string $expect): void
    {
        $this->assertSame(
            $expect,
            number_format((new Minus())->params($params)($data), 2)
        );
    }

    public function cases(): array
    {
        return [
            '1 - 1' => [[1, 1], null, '0.00'],
            '3.1415926 - 2.7182818' => [[3.1415926, 2.7182818], null, '0.42'],
            '1/3 - 2/3' => [[1/3, 2/3], null, '-0.33'],
            '1/2 - 1/3 - 1/4 - 1/5 - 1/6' => [[1/2, 1/3, 1/4, 1/5, 1/6], null, '-0.45'],
            'Pi - e' => [
                [
                    ['var' => 'real.irrational.Pi'],
                    ['var' => 'real.irrational.e'],
                ],
                [
                    'real' => [
                        'irrational' => [
                            'Pi' => 3.1415926,
                            'e' => 2.7182818,
                        ],
                    ],
                ],
                '0.42',
            ],
        ];
    }
}
