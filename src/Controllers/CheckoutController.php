<?php

namespace Src\Controllers;

use Src\Services\CheckoutService;

class CheckoutController extends Controller
{
    public array $items;

    /**
     * set the rules
     *
     * @param  array $rules
     * @return void
     */
    public function __construct(public array $rules)
    {
        parent::__construct();
        $this->service = new CheckoutService($this->rules);
    }

    /**
     * scan items and store
     *
     * @param  string $item name of the item
     * @return void
     */
    public function scan(string $item): void
    {
        $this->service->scan($item);
    }

    /**
     * calculate total amount of the cart.
     *
     * @return integer total price
     */
    public function total(): int
    {
        return $this->service->total();
    }
}
