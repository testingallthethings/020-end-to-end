<?php

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;

$isDevMode = true;
$config = Setup::createYAMLMetadataConfiguration([__DIR__ . "/../config/yaml"], $isDevMode);

$conn = array(
    "driver" => "pdo_pgsql",
    "user" => "tester",
    "password" => "testing",
    "host" => "db",
);

$entityManager = EntityManager::create($conn, $config);