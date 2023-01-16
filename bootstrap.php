<?php
// di_container.php 
require_once __DIR__ . '/vendor/autoload.php';

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
use Symfony\Component\DependencyInjection\Reference;

// init service container 
$containerBuilder = new ContainerBuilder();

$loader = new PhpFileLoader($containerBuilder, new FileLocator(__DIR__));
$loader->load('config/di_services.php');

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

