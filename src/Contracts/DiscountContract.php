<?php

namespace Src\Contracts;

interface DiscountContract
{
    public function calculateDiscant(int $totalQuantity): float;
}