<?php
namespace Tests\JsonLogic;

use JsonLogic\JsonLogic;
use Tests\TestCase;

class JsonLogicTest extends TestCase
{
    /** @dataProvider provider */
    public function testApply($rule, $data, $expect): void
    {
        $this->assertSame(
            $expect,
            JsonLogic::apply($rule, $data)
        );
    }

    public function provider(): array
    {
        return [
            ['{"var": [1]}', ['hello', 'json-logic'], 'json-logic'],
            ['{"and": [{"var": ["key"]}]}', ['key' => 0], false],
            ['{"==": [{"var": [1]}, {"var": [4]}]}', ['T', 'A', 'I', 'W', 'A', 'N'], true],
            ['{"==": [{"var": [1]}, {"var": [2]}, {"var": [3]}]}', ['🤎', '🤎', '🧡'], false],
            ['{">": [{"var": [2]}, {"var": [1]}, {"var": [0]}]}', ['F', 'A', 'Q'], false],
            ['{">": [{"var": [2]}, {"var": [0]}, {"var": [1]}]}', ['F', 'A', 'Q'], true],
        ];
    }
}
