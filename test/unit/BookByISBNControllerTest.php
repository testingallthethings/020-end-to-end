<?php
namespace Braddle;

use PHPUnit\Framework\TestCase;
use Slim\Exception\HttpInternalServerErrorException;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class BookByISBNControllerTest extends TestCase
{
    public function testBookRetrievalError()
    {
        $this->expectException(HttpInternalServerErrorException::class);

        $r = \Mockery::mock(ISBNBookRetriever::class);
        $r->shouldReceive("retrieveBookByISBN")
            ->andThrow(new BookRetrievalException("Broken"));

        $req = \Mockery::mock(Request::class);

        $c = new BookByISBNController($r);
        $c($req, new Response(), ["isbn" => "444444444"]);
    }
}
