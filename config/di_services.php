<?php

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Ampliffy\CiCd\Domain\Repositories\CommitRepositoryInterface;
use Ampliffy\CiCd\Domain\Repositories\RepositoryRepositoryInterface;
use Ampliffy\CiCd\Infrastructure\EntityManager;
use Ampliffy\CiCd\Domain\Services\CommitService;
use Ampliffy\CiCd\Domain\Services\ComposerJsonService;
use Ampliffy\CiCd\Domain\Services\DependencyTreeService;
use Ampliffy\CiCd\Domain\Services\RepositoryService;
use Ampliffy\CiCd\Infrastructure\Repositories\BaseDoctrineRepository;
use Ampliffy\CiCd\Infrastructure\Repositories\CommitDoctrineRepository;
use Ampliffy\CiCd\Infrastructure\Repositories\RepositoryDoctrineRepository;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator) {
        
    $services = $containerConfigurator->services();
    $services->set('doctrine.em', EntityManager::class);

    //$services->set(BaseDoctrineRepository::class)
    //    ->abstract()
    //    ->args([service('doctrine.em')]);

    $services->set('doctrine.repositories.repository', RepositoryDoctrineRepository::class)
        ->args([service('doctrine.em')])
    ;

    $services->set('doctrine.repositories.commit', CommitDoctrineRepository::class)
        ->args([service('doctrine.em')])
    ;

    $services->alias(RepositoryRepositoryInterface::class, RepositoryDoctrineRepository::class);
    //$services->set('repositories.commit', CommitRepositoryInterface::class);

    $services->alias(CommitRepositoryInterface::class, CommitDoctrineRepository::class);

    $services->set('services.composer_json', ComposerJsonService::class);
    
    $services->set('services.dependency_tree', DependencyTreeService::class)
        ->args([service('services.composer_json'), service('doctrine.repositories.repository')])
        ;

    $services->set('services.repository', RepositoryService::class)
        ->args([service('doctrine.repositories.repository'), service('services.dependency_tree'), service('services.composer_json')]);

    $services->set('services.commit', CommitService::class)
        ->args([service('doctrine.repositories.commit'), service('services.repository')]);

    

    $services->set(CommitDoctrineRepository::class)
        ->parent(BaseDoctrineRepository::class);

    

};