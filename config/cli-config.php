<?php

use Doctrine\ORM\Tools\Console\ConsoleRunner;

require_once __DIR__.'/../bootstrap.php';

$em = $containerBuilder->get('doctrine.em')->get();

return ConsoleRunner::createHelperSet($em);
