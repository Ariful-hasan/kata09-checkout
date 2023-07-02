<?php

namespace Src\Services;

use Src\Contracts\DiscountContract;
use Src\Contracts\PolicyContract;

class PricePolicy implements PolicyContract
{    
    /**
     * set the price and Discount (nullable)
     * 
     * @param  float $price
     * @param  DiscountContract $discount
     * @return void
     */
    function __construct(public float $price, public ?DiscountContract $discount)
    {
        
    }
    
    /**
     * calculate the final price for the item with discount
     *
     * @param  int $quantity
     * @return float the final price
     */
    function getPrice(int $quantity): float
    {
        if ($this->discount instanceof DiscountContract) {
            return (float) ($quantity * $this->price) - $this->discount->calculateDiscant($quantity);
        }

        return (float) ($quantity * $this->price);
    }
}