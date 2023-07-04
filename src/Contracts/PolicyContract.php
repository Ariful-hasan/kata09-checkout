<?php

namespace Src\Contracts;

interface PolicyContract
{
    public function getPrice(int $quantity): float;
}
