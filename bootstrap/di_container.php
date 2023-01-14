<?php
// di_container.php 
require_once __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Ampliffy\CiCd\Infrastructure\EntityManager;

// init service container 
$containerBuilder = new ContainerBuilder();
 
// add demo service into the service container 
$containerBuilder->register('doctrine.em', EntityManager::class);

