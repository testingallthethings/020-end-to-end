<?php

namespace Braddle;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use PHPUnit\Framework\TestCase;

class BooksTest extends TestCase
{
    private EntityManager $entityManager;

    protected function setUp() : void
    {
        $isDevMode = true;
        $config = Setup::createYAMLMetadataConfiguration([__DIR__ . "/../../config/yaml"], $isDevMode);

        $conn = array(
            "driver" => "pdo_pgsql",
            "user" => "tester",
            "password" => "testing",
            "host" => "db",
        );

        $this->entityManager = EntityManager::create($conn, $config);
    }

    public function testGetBookByISBN()
    {
        $book = new Book(
            "123456789",
            "Testing All The Things",
            "Mark Bradley",
            564
        );

        $this->entityManager->persist($book);
        $this->entityManager->flush();

        $client = new Client(["base_uri" => "http://api"]);
        $response = $client->get(
            "/book/123456789",
            [
                "headers" => [
                    "Accept" => "application/json"
                ]
            ]
        );

        $this->assertEquals(200, $response->getStatusCode());

        $expectedJson = [
            "isbn" =>"123456789",
            "title" => "Testing All The Things",
            "author" => "Mark Bradley",
            "number_of_pages" => 564,
        ];
        $actualJson = json_decode($response->getBody()->getContents(), true);

        $this->assertEquals($expectedJson, $actualJson);
    }

    public function testGetByISBNThatDoesNotExist()
    {
        $client = new Client(["base_uri" => "http://api"]);

        try {
            $client->get(
                "/book/555555555",
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