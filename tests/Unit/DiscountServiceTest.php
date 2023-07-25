<?php

use PHPUnit\Framework\TestCase;
use Src\Services\DiscountService;

class DiscountServiceTest extends TestCase
{
    function testCalculateDiscountPrice()
    {
        $discount = new DiscountService(20, 3);
        $result = $discount->calculateDiscant(1);

        $this->assertEquals(0, $result);

        $discount = new DiscountService(20, 3);
        $result = $discount->calculateDiscant(5);

        $this->assertEquals(33.33, $result);
    }
}