<?php
namespace Braddle;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use PHPUnit\Framework\TestCase;

class NotFoundTest extends TestCase
{
    public function testNotFound()
    {
        $client = new Client(["base_uri" => "http://api"]);

        try {
            $client->get(
                "/never/here",
                [
                    "headers" => [
                        "Accept" => "application/json"
                    ]
                ]
            );
        } catch (ClientException $e) {
            $response = $e->getResponse();
        }

        $this->assertEquals(404, $response->getStatusCode());

        $expectedBody = [
            "status" => 404,
            "title" => "Not Found",
        ];
        $actualBody = json_decode($response->getBody()->getContents(), true);

        $this->assertEquals($expectedBody, $actualBody);
    }


}