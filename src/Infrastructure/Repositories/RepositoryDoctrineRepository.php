<?php

declare(strict_types = 1);

namespace Ampliffy\CiCd\Infrastructure\Repositories;

use Ampliffy\CiCd\Domain\Dto\RepositoryDto;
use Ampliffy\CiCd\Domain\Entities\Repository;
use Doctrine\Common\Collections\ArrayCollection;
use Ampliffy\CiCd\Domain\Repositories\RepositoryRepositoryInterface;

class RepositoryDoctrineRepository extends BaseDoctrineRepository implements RepositoryRepositoryInterface
{
    public function getAll() : ArrayCollection
    {
        $repositories = $this->queryBuilder->select('r')
            ->from(Repository::class, 'r')
            ->getQuery()
            ->getResult();

        return new ArrayCollection($repositories);
    }

    public function getByGitPath(string $gitPath) : Repository|null
    {
        $query = $this->em->createQuery('SELECT a FROM Ampliffy\CiCd\Domain\Entities\Repository a WHERE a.gitPath = :gitPath');
        $query->setParameter('gitPath', $gitPath);
        
        return $query->setMaxResults(1)
            ->getOneOrNullResult();
    }

    public function getByComposerName(string $composerName) : Repository|null
    {
        $query = $this->em->createQuery('SELECT a FROM Ampliffy\CiCd\Domain\Entities\Repository a WHERE a.composerName = :composerName');
        $query->setParameter('composerName', $composerName);
        
        return $query->setMaxResults(1)
            ->getOneOrNullResult();
    }

    public function update(Repository $repository) : Repository
    {
        $this->em->persist($repository);
        $this->em->flush();

        return $repository;
    }

    public function createRepository(RepositoryDto $repositoryDto) : Repository
    {       
        $repository = (new Repository)
            ->setComposerName($repositoryDto->composer_name)
            ->setGitPath($repositoryDto->git_path)
            ->setType($repositoryDto->type);

        $this->em->persist($repository);
        
        $this->em->flush();

        return $repository;
    }

    public function doesNotExistByGitPath(string $gitPath) : bool
    {
        return is_null($this->getByGitPath($gitPath));
    }
}