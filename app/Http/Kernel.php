<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{protected $routeMiddleware = [
    // autres middlewares...
    'check.client.session' => \App\Http\Middleware\CheckClientSession::class,
];

}
