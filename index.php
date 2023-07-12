<?php

use Src\Controllers\CheckoutController;
use Src\Services\DiscountService;
use Src\Services\PricePolicyService;

require_once __DIR__ . '/src/bootstrap.php';

$rules = [
    'A' => new PricePolicyService(50, new DiscountService(20, 3)),
    'B' => new PricePolicyService(30, new DiscountService(15, 2)),
    'C' => new PricePolicyService(20, null),
    'D' => new PricePolicyService(15, null),
];

$checkout = new CheckoutController($rules);
$checkout->scan('A');
$checkout->scan('B');
$checkout->scan('A');
$checkout->scan('A');
$checkout->scan('B');
$totalPrice = $checkout->total();
var_dump($totalPrice);