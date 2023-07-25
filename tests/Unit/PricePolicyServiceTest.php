<?php

use PHPUnit\Framework\TestCase;
use Src\Services\DiscountService;
use Src\Services\PricePolicyService;

class PricePolicyServiceTest extends TestCase
{
    function testPrice() 
    {
        $policy = new PricePolicyService(20.00, null);
        $result = $policy->getPrice(3);

        $this->assertEquals(60.00, $result);

        $policy = new PricePolicyService(20.00, new DiscountService(20, 3));
        $result = $policy->getPrice(3);

        $this->assertEquals(40.00, $result);
    }
}