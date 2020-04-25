<?php

use Doctrine\ORM\Tools\Console\ConsoleRunner;

require_once __DIR__ . "/app/database.php";

return ConsoleRunner::createHelperSet($entityManager);
