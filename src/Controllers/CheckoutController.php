<?php

namespace Src\Controllers;

use Src\Contracts\PolicyContract;
use Src\Exceptions\RulesNotFountException;

class CheckoutController extends BaseController
{
    private array $items;

    public function __construct(public array $rules)
    {
        $this->items = [];
    }

    public function scan(string $item): void
    {
        if (!isset($this->items[$item])) {
            $this->items[$item] = 0;
        }
        $this->items[$item] += 1;
    }

    public function total() 
    {
        if (empty($this->items))
        {
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

    function getItemTotalPrice(string $item, int $quantity) : int
    {
        $policy = $this->itemRule($item);

        if ($policy !== null) {
            return (int)$policy->getPrice($quantity);
        } else {
            throw new RulesNotFountException('Rule is not Found for this item');
        }
    }

    function itemRule(string $item) : ?PolicyContract 
    {
        return $this->rules[$item] ?? null;
    }
}