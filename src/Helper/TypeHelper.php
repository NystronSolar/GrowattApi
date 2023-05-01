<?php

namespace NystronSolar\GrowattApi\Helper;

class TypeHelper
{
    public static function castToBool(mixed $var, bool $default = false): bool
    {
        $var = is_bool($var) ? $var : $default;

        return $var;
    }

    public static function castToInt(mixed $var, int $default = 0): int
    {
        $var = is_int($var) ? $var : $default;

        return $var;
    }

    public static function castToFloat(mixed $var, float $default = 0.0): float
    {
        $var = is_float($var) ? $var : $default;

        return $var;
    }

    public static function castToString(mixed $var, string $default = ''): string
    {
        $var = is_string($var) ? $var : $default;

        return $var;
    }

    public static function castToArray(mixed $var, array $default = []): array
    {
        $var = is_array($var) ? $var : $default;

        return $var;
    }

    public static function castToObject(mixed $var, object $default = new \stdClass()): object
    {
        $var = is_object($var) ? $var : $default;

        return $var;
    }

    public static function isBool(mixed $var, bool $trueForNull = false): bool
    {
        $isBool = is_bool($var);

        if ($trueForNull && !$isBool) {
            $isNull = is_null($var);

            return $isNull;
        }

        return $isBool;
    }

    public static function isInt(mixed $var, bool $trueForNull = false): bool
    {
        $isInt = is_int($var);

        if ($trueForNull && !$isInt) {
            $isNull = is_null($var);

            return $isNull;
        }

        return $isInt;
    }

    public static function isFloat(mixed $var, bool $trueForNull = false): bool
    {
        $isFloat = is_float($var);

        if ($trueForNull && !$isFloat) {
            $isNull = is_null($var);

            return $isNull;
        }

        return $isFloat;
    }

    public static function isString(mixed $var, bool $trueForNull = false): bool
    {
        $isString = is_string($var);

        if ($trueForNull && !$isString) {
            $isNull = is_null($var);

            return $isNull;
        }

        return $isString;
    }

    public static function isArray(mixed $var, bool $trueForNull = false): bool
    {
        $isArray = is_array($var);

        if ($trueForNull && !$isArray) {
            $isNull = is_null($var);

            return $isNull;
        }

        return $isArray;
    }

    public static function isObject(mixed $var, bool $trueForNull = false): bool
    {
        $isObject = is_object($var);

        if ($trueForNull && !$isObject) {
            $isNull = is_null($var);

            return $isNull;
        }

        return $isObject;
    }
}
