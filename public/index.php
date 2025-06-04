<?php
require __DIR__ . "/../vendor/autoload.php";

use Slim\Factory\AppFactory;

$app = AppFactory::create();
$app->addBodyParsingMiddleware();

(require __DIR__ . '/../src/Routes/Route.php')($app);

$app->run();