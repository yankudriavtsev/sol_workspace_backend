<?php

namespace App\Http\Controllers;

use Psr\Log\LoggerInterface;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    protected LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }
}
