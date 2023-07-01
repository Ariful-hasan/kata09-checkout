<?php

namespace Src\Contracts;

interface PolicyContract 
{
    function __construct();

    public function getPrice(int $quantity): float;
}