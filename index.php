<?php

use Src\Controllers\CheckoutController;
use Src\Services\Discount;
use Src\Services\PricePolicy;

require_once __DIR__ . '/src/bootstrap.php';

$rules = [
    'A' => new PricePolicy(50, new Discount(20, 3)),
    'B' => new PricePolicy(30, new Discount(15, 2)),
    'C' => new PricePolicy(20, null),
    'D' => new PricePolicy(15, null),
];

$checkout = new CheckoutController($rules);
$checkout->scan('A');
$checkout->scan('B');
$checkout->scan('A');
$totalPrice = $checkout->total();

var_dump($totalPrice);