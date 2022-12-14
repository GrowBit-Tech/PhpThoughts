<?php

use GrowBitTech\Framework\Middleware\TrailingMiddleware;
use Selective\BasePath\BasePathMiddleware;
use Slim\App;

return function (App $app) {
    // Parse json, form data and xml
    $app->addBodyParsingMiddleware();

    // Add the Slim built-in routing middleware
    $app->addRoutingMiddleware();

    $app->add(new BasePathMiddleware($app));

    $app->add(TrailingMiddleware::class);

    // Handle exceptions
    $app->addErrorMiddleware(true, true, true);
};
