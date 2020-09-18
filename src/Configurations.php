<?php
namespace JsonLogic;

class Configurations
{
    const PRESET_ECMASCRIPT = 'ECMAScript';
    const PRESET_JAVASCRIPT = 'ECMAScript';
    const PRESET_JS = 'ECMAScript';
    const PRESET_JSON_LOGIC = 'JsonLogic';
    const PRESET_PHP = 'PHP';

    const TRUTHY_EMPTY_ARRAY = 'truthy-empty-array';
    const TRUTHY_STRING_0 = 'truthy-string-zero';

    const VALIDATE_PARAMETER_BEFORE_EXECUTION = 'validate-parameters';

    const PRESETS = [
        'PHP' => [
            'truthy-empty-array' => false,
            'truthy-string-zero' => false,
        ],
        'ECMAScript' => [
            'truthy-empty-array' => true,
            'truthy-string-zero' => true,
        ],
        'JsonLogic' => [
            'truthy-empty-array' => false,
            'truthy-string-zero' => true,
        ],
    ];

    private static $configs = [
        'truthy-empty-array' => false,
        'truthy-string-zero' => true,
        'validate-parameters' => true,
    ];

    public static function get($key, $default = null)
    {
        return static::$configs[$key] ?? $default;
    }

    public static function set($key, $value): void
    {
        static::$configs[$key] = $value;
    }

    public static function applyLanguagePresets(string $preset): void
    {
        foreach (static::PRESETS[$preset] ?? [] as $key => $value) {
            static::set($key, $value);
        }
    }
}
