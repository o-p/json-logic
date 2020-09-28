<?php
namespace Tests\JsonLogic\Operators;

use JsonLogic\Operators\Divide;
use Tests\TestCase;

use function number_format;

/**
 * @group operators
 */
class DivideTest extends TestCase
{
    /** @dataProvider cases */
    public function test(array $params, $data, string $expect): void
    {
        $this->assertSame(
            $expect,
            number_format((new Divide())->params($params)($data), 3)
        );
    }

    public function cases(): array
    {
        return [
            '1 ÷ 1' => [[1, 1], null, '1.000'],
            '3.1415926 ÷ 2.7182818' => [[3.1415926, 2.7182818], null, '1.156'],
            '5/7 ÷ 25/49' => [[5/7, 25/49], null, '1.400'],
            '1/2 ÷ 3/2 ÷ 4/3 ÷ 5/4' => [[1/2, 3/2, 4/3, 5/4], null, '0.200'],
            'Pi ÷ e' => [
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
                '1.156',
            ],
        ];
    }
}
