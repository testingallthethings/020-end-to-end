<?php

use Braddle\BookByISBNController;
use Braddle\BookNotFoundException;
use Braddle\BookRepository;
use DI\Container;
use Psr\Container\ContainerInterface;
use Slim\Exception\HttpNotFoundException;
use Slim\Factory\AppFactory;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

require_once __DIR__ . "/../vendor/autoload.php";
require_once __DIR__ . "/database.php";

$container = new Container();

AppFactory::setContainer($container);
$app = AppFactory::create();

$container->set(BookByISBNController::class, function (ContainerInterface $c){
   return new BookByISBNController($c->get("book-manager"));
});

$container->set("book-manager", function (ContainerInterface $c){
   return new \Braddle\BookManager($c->get("book-repo"));
});

$container->set("book-repo", function () use ($entityManager) {
   return new BookRepository($entityManager);
});

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

$app->get("/book/{isbn}", BookByISBNController::class);

$app->run();