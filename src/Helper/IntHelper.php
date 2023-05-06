<?php

namespace NystronSolar\GrowattApi\Helper;

class IntHelper
{
    public static function limitTo(int $num, int $limit): int
    {
        return $num > $limit ? $limit : $num;
    }

    public static function negativeTo(int $num, int $to): int
    {
        return $num < $to ? $to : $num;
    }

    public static function negativeToZero(int $num): int
    {
        return static::negativeTo($num, 0);
    }

    public static function negativeToOne(int $num): int
    {
        return static::negativeTo($num, 1);
    }
}
