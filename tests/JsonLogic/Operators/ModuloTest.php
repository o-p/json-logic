<?php
namespace Tests\JsonLogic\Operators;

use JsonLogic\Operators\Modulo;
use Tests\TestCase;

/**
 * @group operators
 */
class ModuloTest extends TestCase
{
    /** @dataProvider cases */
    public function test(array $params, $data, int $expect): void
    {
        $this->assertSame(
            $expect,
            (new Modulo())->params($params)($data)
        );
    }

    public function cases(): array
    {
        return [
            '1 % 1' => [[1, 1], null, 0],
            '100 % 3' => [[100, 3], null, 1],
            '100 % 23 % 17 % 5' => [[100, 23, 17, 5], null, 3],
            '100 % 17' => [
                [
                    ['var' => 'one hundred'],
                    ['var' => 'seventeen'],
                ],
                [
                    'one hundred' => 100,
                    'seventeen' => 17,
                ],
                15,
            ],
        ];
    }
}
