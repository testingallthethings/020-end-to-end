<?php

namespace Braddle;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
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

    public function testPlaceholder()
    {
        $this->assertTrue(true);
    }


}