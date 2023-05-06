<?php

namespace NystronSolar\GrowattApiTests\Helper;

use NystronSolar\GrowattApi\Helper\IntHelper;
use PHPUnit\Framework\TestCase;

class IntHelperTest extends TestCase
{
    public function testLimitToBiggerLimit()
    {
        $this->assertSame(100, IntHelper::limitTo(300, 100));
    }

    public function testLimitToEqualsLimit()
    {
        $this->assertSame(100, IntHelper::limitTo(100, 100));
    }

    public function testLimitToSmallestLimit()
    {
        $this->assertSame(50, IntHelper::limitTo(50, 100));
    }

    public function testNegativeToZeroWithPositive()
    {
        $this->assertSame(10, IntHelper::negativeToZero(10));
    }

    public function testNegativeToZeroWithZero()
    {
        $this->assertSame(0, IntHelper::negativeToZero(0));
    }

    public function testNegativeToZeroWithNegative()
    {
        $this->assertSame(0, IntHelper::negativeToZero(-10));
    }
}