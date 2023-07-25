<?php

use PHPUnit\Framework\TestCase;
use Src\Controllers\CheckoutController;
use Src\Services\DiscountService;
use Src\Services\PricePolicyService;

class CheckoutFeatureTest extends TestCase
{
    private array $rules;
    
    function setUp(): void
    {
        $this->rules = [
            'A' => new PricePolicyService(50, new DiscountService(20, 3)),
            'B' => new PricePolicyService(30, new DiscountService(15, 2)),
            'C' => new PricePolicyService(20, null),
            'D' => new PricePolicyService(15, null),
        ];
    }

    function testItemTotalPrice()
    {
        $checkoutController = new CheckoutController($this->rules);
        $checkoutController->scan('A');
        $result = $checkoutController->getItemTotalPrice('A', 1);

        $this->assertEquals(50, $result);

        $checkoutController->scan('A');
        $checkoutController->scan('A');
        $result = $checkoutController->getItemTotalPrice('A', 3);

        $this->assertEquals(130, $result);
    }

    function testScanItem()
    {
        $checkoutController = new CheckoutController($this->rules);

        $this->assertEmpty($checkoutController->items);

        $checkoutController->scan('A');
        $checkoutController->scan('B');
        $checkoutController->scan('C');

        $this->assertCount(3, $checkoutController->items);
        
    }
}