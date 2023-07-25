<?php

namespace Src\Services;

use Src\Contracts\DiscountContract;

class DiscountService implements DiscountContract
{
    /**
     * set the initial discount amount and discount price
     *
     * @param  int $discountQuantity
     * @param  float $discountPrice
     * @return void
     */
    public function __construct(public float $discountPrice, public int $discountQuantity)
    {
    }

    /**
     * calculate the discount amount for the given quantity.
     *
     * @param  int $totalQuantity
     * @return float
     */
    public function calculateDiscant(int $totalQuantity): float
    {
        return $totalQuantity < $this->discountQuantity
            ? 0
            : number_format(($totalQuantity / $this->discountQuantity) * $this->discountPrice, 2);
    }
}
