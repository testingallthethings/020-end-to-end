<?php

namespace Braddle;

use PHPUnit\Framework\TestCase;
use Slim\Exception\HttpNotFoundException;
use Slim\Psr7\Headers;
use Slim\Psr7\NonBufferedBody;
use Slim\Psr7\Request;
use Slim\Psr7\Uri;

class ApiProblemRendererTest extends TestCase
{
    public function testNotFoundException()
    {
        $e = new HttpNotFoundException(
            new Request(
                "GET",
                new Uri(
                    "http",
                    "coolapp.com",
                    null,
                    "/not/here"
                ),
                new Headers(),
                [],
                [],
                new NonBufferedBody()
            )
        );

        $renderer = new ApiProblemRenderer();

        $body = $renderer($e, true);

        $actualBody = json_decode($body, true);
        $expectedBody = [
            "status" => 404,
            "title" => "Not Found",
        ];

        $this->assertEquals($expectedBody, $actualBody);
    }


}