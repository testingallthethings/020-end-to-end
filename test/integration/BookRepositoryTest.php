<?php

namespace Braddle;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use PHPUnit\Framework\TestCase;

class BookRepositoryTest extends TestCase
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

    public function testGetByISBN()
    {
        $expectedBook = new Book(
            "987654321",
            "Even More Tesing",
            "Mark Bradley",
            2900
        );

        $this->entityManager->persist($expectedBook);
        $this->entityManager->flush();

        $bookRepo = new BookRepository($this->entityManager);
        $actualBook = $bookRepo->getByISBN("987654321");

        $this->assertEquals($expectedBook, $actualBook);
    }

    public function testGetByISBNThatDoesNotExist()
    {
        $this->expectException(BookNotFoundException::class);

        $bookRepo = new BookRepository($this->entityManager);
        $bookRepo->getByISBN("444444444");
    }

    public function testHandlingDBHasGoneAway()
    {
        $isDevMode = true;
        $config = Setup::createYAMLMetadataConfiguration([__DIR__ . "/../../config/yaml"], $isDevMode);

        $conn = array(
            "driver" => "pdo_pgsql",
            "user" => "hacker",
            "password" => "nottesting",
            "host" => "db",
        );

        $entityManager = EntityManager::create($conn, $config);

        $this->expectException(BookRepositoryException::class);

        $bookRepo = new BookRepository($entityManager);
        $bookRepo->getByISBN("444444444");
    }


}