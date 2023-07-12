<?php

namespace Src\Controllers;

use Src\Services\Service;

class Controller
{
    public Service $service;

    public function __construct()
    {
        $this->service = new Service();
    }
}
