<?php

namespace Src\Controllers;

use Src\Contracts\PolicyContract;
use Src\Exceptions\RulesNotFountException;

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
        $this->items = [];
    }

    /**
     * scan items and store
     *
     * @param  string $item name of the item
     * @return void
     */
    public function scan(string $item): void
    {
        if (!isset($this->items[$item])) {
            $this->items[$item] = 0;
        }
        $this->items[$item] += 1;
    }

    /**
     * calculate total amount of the cart.
     *
     * @return integer total price
     */
    public function total(): int
    {
        if (empty($this->items)) {
            return 0;
        }

        $total = 0;

        foreach ($this->items as $item => $count) {
            if (isset($this->rules[$item])) {
                $total += $this->getItemTotalPrice($item, $count);
            }
        }

        return $total;
    }

    /**
     * find the rules exist or not and return the price
     *
     * @param  string $item
     * @param  int $quantity
     * @return int price
     */
    public function getItemTotalPrice(string $item, int $quantity): int
    {
        $policy = $this->itemRule($item);

        if ($policy !== null) {
            return (int)$policy->getPrice($quantity);
        } else {
            throw new RulesNotFountException('Rule is not Found for this item');
        }
    }

    public function itemRule(string $item): ?PolicyContract
    {
        return $this->rules[$item] ?? null;
    }
}
