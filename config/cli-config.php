<?php

use Ampliffy\CiCd\Infrastructure\EntityManager;
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Symfony\Component\DependencyInjection\ContainerBuilder;

require_once __DIR__.'/../bootstrap.php';

$em = $containerBuilder->get('doctrine.em')->get();

return ConsoleRunner::createHelperSet($em);
