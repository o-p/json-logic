<?php
namespace Tests\JsonLogic\Operators;

use JsonLogic\Operators\VarOperator;
use Tests\TestCase;

/**
 * @group operators
 */
class VarOperatorTest extends TestCase
{
    /** @dataProvider cases */
    public function test($arguments, $data, $expect): void
    {
        $this->assertSame(
            $expect,
            (new VarOperator())->params($arguments)($data)
        );
    }

    public function cases(): array
    {
        return [
            'Get from 1 level with existed path' => [
                ['id'],
                ['id' => 5566],
                5566,
            ],
            'Get from 1 level with inexisted path without default' => [
                ['name'],
                ['id' => 5566],
                null,
            ],
            'Get from 1 level with inexisted path with default' => [
                ['name', 'Nico Robin'],
                ['id' => 5566],
                'Nico Robin',
            ],
            'Get from 3 level with existed path' => [
                ['screen.size.y'],
                ['screen' => ['size' => ['x' => 1024, 'y' => 768]]],
                768,
            ],
            'Get from 3 level with inexisted path without default' => [
                ['screen.view.y'],
                ['screen' => ['size' => ['x' => 1024, 'y' => 768]]],
                null,
            ],
            'Get from 3 level with inexisted path witho default' => [
                ['screen.view.y', 0],
                ['screen' => ['size' => ['x' => 1024, 'y' => 768]]],
                0,
            ],
        ];
    }
}
