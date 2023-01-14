<?php

namespace Ampliffy\CiCd\Infrastructure;

use Dotenv\Dotenv;
use Doctrine\ORM\Tools\Setup;

class EntityManager
{
    private $em;

    private static $instances = [];

    public function __construct()
    {
        $dotenv = Dotenv::createImmutable(__DIR__.'/../../');
        $dotenv->load();

        $paths = array(__DIR__.'/../Entities');
        $isDevMode = true;

        $dbParams = array(
            'host' => $_ENV['DB_HOST'],
            'driver' => $_ENV['DB_DRIVER'],
            'user' => $_ENV['DB_USERNAME'],
            'password' => $_ENV['DB_PASSWORD'],
            'dbname' => $_ENV['DB_DATABASE'],
        );

        $config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode, null, null, false);
        $this->em = \Doctrine\ORM\EntityManager::create($dbParams, $config);
    }

    protected function __clone() { }

    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize singleton");
    }

    public static function getInstance()
    {
        $subclass = static::class;
        if (!isset(self::$instances[$subclass])) {
            self::$instances[$subclass] = (new static())->em;
        }
        return self::$instances[$subclass];
    }

    public function get()
    {
        return $this->em;
    }
}