<?php
namespace Tests\JsonLogic\Operators;

use JsonLogic\Operators\Multiply;
use Tests\TestCase;

use function number_format;

/**
 * @group operators
 */
class MultiplyTest extends TestCase
{
    /** @dataProvider cases */
    public function test(array $params, $data, string $expect): void
    {
        $this->assertSame(
            $expect,
            number_format((new Multiply())->params($params)($data), 2)
        );
    }

    public function cases(): array
    {
        return [
            '1 x 1' => [[1, 1], null, '1.00'],
            '3.1415926 x 2.7182818' => [[3.1415926, 2.7182818], null, '8.54'],
            '5/7 x 49/5' => [[5/7, 49/5], null, '7.00'],
            '1/2 * 2/3 * 3/4 * 4/5' => [[1/2, 2/3, 3/4, 4/5], null, '0.20'],
            'Pi + e' => [
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
                '8.54',
            ],
        ];
    }
}
