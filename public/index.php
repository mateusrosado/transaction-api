<?php
require __DIR__ . "/../vendor/autoload.php";

use Slim\Factory\AppFactory;
use Src\Middlewares\JsonContentTypeMiddleware;

$app = AppFactory::create();

$errorMiddleware = $app->addErrorMiddleware(true, true, true);
$app->addBodyParsingMiddleware();
$app->addRoutingMiddleware(); 
$app->add(JsonContentTypeMiddleware::class);

(require __DIR__ . '/../src/Routes/Route.php')($app);

$app->run();