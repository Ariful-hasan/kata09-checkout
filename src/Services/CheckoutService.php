<?php

namespace Src\Services;

use Src\Contracts\PolicyContract;
use Src\Exceptions\RulesNotFountException;

class CheckoutService extends Service
{
    private array $items;

    public function __construct(protected array $rules)
    {
        parent::__construct();
        $this->items = [];
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

        return (int)$policy->getPrice($quantity);
    }

    public function itemRule(string $item): ?PolicyContract
    {
        if ($this->rules[$item] && !$this->rules[$item] instanceof PolicyContract) {
            throw new RulesNotFountException('Rule is not Found for this item');
        }

        return $this->rules[$item] ?? null;
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

    public function scan(string $item): void
    {
        if (!isset($this->items[$item])) {
            $this->items[$item] = 0;
        }

        $this->items[$item] += 1;
    }
}
