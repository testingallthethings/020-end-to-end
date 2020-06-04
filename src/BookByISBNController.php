<?php
declare(strict_types=1);

namespace Braddle;

use Psr\Container\ContainerInterface;
use Slim\Exception\HttpInternalServerErrorException;
use Slim\Exception\HttpNotFoundException;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class BookByISBNController
{
    private ISBNBookRetriever $retriever;

    public function __construct(ISBNBookRetriever $retriever)
    {
        $this->retriever = $retriever;
    }

    public function __invoke(Request $req, Response $resp, $args) : Response{
        try {
            $book = $this->retriever->retrieveBookByISBN($args["isbn"]);
        } catch (BookNotFoundException $e) {
            throw new HttpNotFoundException($req, "No Book Found", $e);
        } catch (BookRetrievalException $e) {
            throw new HttpInternalServerErrorException($req, "Something went wrong retrieving your book", $e);
        }

        $json = json_encode($book);

        $resp->getBody()->write($json);

        return $resp;
    }
}