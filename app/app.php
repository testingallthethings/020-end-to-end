<?php

use Slim\Factory\AppFactory;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

require_once __DIR__ . "/../vendor/autoload.php";

$app = AppFactory::create();

$errorMiddleware = $app->addErrorMiddleware(true, true,true);
$errorHandler = $errorMiddleware->getDefaultErrorHandler();
$errorHandler->registerErrorRenderer(
    "application/json",
    \Braddle\ApiProblemRenderer::class
);


$app->get("/health", function (Request $req, Response $resp){
    $body = json_encode(["status" => "OK", "errors" => []]);

    $resp->getBody()->write($body);

    return $resp;
});

$app->run();