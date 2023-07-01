<?php

namespace Src\Contracts;

interface DiscountContract
{
    function __construct(int $discountQuantity, float $discountPrice);

    public function calculateDiscant(int $totalQuantity): float;
}