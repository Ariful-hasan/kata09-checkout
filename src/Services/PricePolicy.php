<?php

namespace Src\Services;

use Src\Contracts\DiscountContract;
use Src\Contracts\PolicyContract;

class PricePolicy implements PolicyContract
{
    function __construct(public float $price, public ?DiscountContract $discount)
    {
        
    }

    function getPrice(int $quantity): float
    {
        if ($this->discount instanceof DiscountContract) {
            return (float) ($quantity * $this->price) - $this->discount->calculateDiscant($quantity);
        }

        return (float) ($quantity * $this->price);
    }
}