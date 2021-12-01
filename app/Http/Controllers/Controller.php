<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @OA\Info(
     *     version="1.0.0",
     *     title="Laravel SIP Swagger API Documentation",
     *     description="Implementation of Swagger with in Laravel",
     * )
     * 
     * @OA\Server(
     *     url=L5_SWAGGER_CONST_HOST,
     *     description="Url from config file",
     * )
     */
}
