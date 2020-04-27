<?php

use Braddle\BookRepository;
use DI\Container;
use Slim\Factory\AppFactory;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

require_once __DIR__ . "/../vendor/autoload.php";
require_once __DIR__ . "/database.php";

$container = new Container();

AppFactory::setContainer($container);
$app = AppFactory::create();

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

$app->get("/book/{isbn}", function (Request $req, Response $resp, $args){
    $bookRepo = $this->get("book-repo");
    $book = $bookRepo->getByISBN($args["isbn"]);

    $json = json_encode($book);

    $resp->getBody()->write($json);

    return $resp;
});

$app->run();