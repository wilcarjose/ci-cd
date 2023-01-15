<?php

declare(strict_types = 1);

namespace Ampliffy\CiCd\Infrastructure\Repositories;

use Ampliffy\CiCd\Infrastructure\EntityManager;

abstract class BaseDoctrineRepository
{
    protected $em;

    protected $queryBuilder;

    public function __construct(protected EntityManager $entityManager)
    {
        $this->em = $entityManager->get();

        $this->queryBuilder = $this->em->createQueryBuilder();
    }
}