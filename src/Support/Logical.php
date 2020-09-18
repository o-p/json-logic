<?php
namespace JsonLogic\Support;

use Closure;
use JsonLogic\Configurations as Config;

use function gettype;
use function strlen;

class Logical
{
    private static $handlers = [];

    public static function truthy($logic): bool
    {
        switch (gettype($logic)) {
            case 'string':
                return (static::handle('string') ?: static::createStringHandler())($logic);
            case 'array':
                return (static::handle('array') ?: static::createArrayHandler())($logic);
            default:
                return (bool) $logic;
        }
    }

    public static function falsy($logic): bool
    {
        return !static::truthy($logic);
    }

    protected static function handle(string $type): ?Closure
    {
        return static::$handlers[$type] ?? null;
    }

    protected static function createStringHandler(): Closure
    {
        if (Config::get(Config::TRUTHY_STRING_0)) {
            static::$handlers['string'] = function (string &$str): bool {
                return strlen($str) > 0;
            };
        } else {
            static::$handlers['string'] = function (string &$str): bool {
                return (bool) $str;
            };
        }
        return static::handle('string');
    }

    protected static function createArrayHandler(): Closure
    {
        if (Config::get(Config::TRUTHY_EMPTY_ARRAY)) {
            static::$handlers['array'] = function (array &$arr): bool {
                return true;
            };
        } else {
            static::$handlers['array'] = function (array &$arr): bool {
                return (bool) $arr;
            };
        }
        return static::handle('array');
    }
}
