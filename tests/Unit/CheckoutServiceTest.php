<?php

use PHPUnit\Framework\TestCase;
use Src\Contracts\PolicyContract;
use Src\Exceptions\RulesNotFountException;
use Src\Services\CheckoutService;
use Src\Services\DiscountService;
use Src\Services\PricePolicyService;

class CheckoutServiceTest extends TestCase
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

    function testItemRuleCouldBeNull() 
    {
        $checkoutService = new CheckoutService($this->rules);
        $result = $checkoutService->itemRule('E');
        
        $this->assertNull($result);
    }

    function testItemRuleIsAInstanceOf() 
    {
        $checkoutService = new CheckoutService($this->rules);
        $result = $checkoutService->itemRule('A');
        
        $this->assertInstanceOf(PolicyContract::class, $result);
    }

    function testTotalPriceForItem()
    {
        $checkoutService = new CheckoutService($this->rules);
        $result = $checkoutService->getItemTotalPrice('A', 1);

        $this->assertEquals(50, $result);

        $result = $checkoutService->getItemTotalPrice('A', 3);

        $this->assertEquals(130, $result);
    }

    function testCanFindExceptionForTotalPrice()
    {
        $checkoutService = new CheckoutService(['A' => 'xyz']);

        $this->expectException(RulesNotFountException::class);
        $this->expectExceptionMessage('Rule is not Found for this item');

        $checkoutService->getItemTotalPrice('A', 1);
    }
}