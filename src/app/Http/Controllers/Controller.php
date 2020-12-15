<?php

namespace App\Http\Controllers;

use Psr\Log\LoggerInterface;
use Laravel\Lumen\Routing\Controller as BaseController;
/**
 * @OA\Info(
 *     description="Sol.Workspace API",
 *     version="1.0.0",
 *     title="",
 *     @OA\Contact(
 *         email="yan.kudriavtsev@gmail.com"
 *     )
 * )
 */

 /**
 * @OA\SecurityScheme(
 *  securityScheme="bearerAuth",
 *  type="http",
 *  scheme="bearer"
 * )
 */
class Controller extends BaseController
{
    protected LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }
}
