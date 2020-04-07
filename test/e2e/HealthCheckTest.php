<?php
declare(strict_types=1);

namespace Braddle;

use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;

class HealthCheckTest extends TestCase
{
    public function testHealthyService()
    {
        $client = new Client(["base_uri" => "http://api"]);

        $response = $client->get("/health");

        $this->assertEquals(200, $response->getStatusCode());

        $expectBody = ["status" => "OK", "errors" => []];
        $actualBody = json_decode($response->getBody()->getContents(), true);

        $this->assertEquals($expectBody, $actualBody);
    }
}