<?php

namespace Ampliffy\CiCd\Domain\Services;

use Ampliffy\CiCd\Domain\Repositories\RepositoryRepositoryInterface;
use Ampliffy\CiCd\Domain\Dto\CommitDto;
use Ampliffy\CiCd\Domain\Entities\Repository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Ampliffy\CiCd\Infrastructure\EntityManager;

class RepositoryService
{
    public function __construct(protected RepositoryRepositoryInterface $repositoryRepository)
    {
        
    }

    public function getAffectedByCommit(CommitDto $commitDto) : Collection
    {
        $repositories = $this->getAll();

        $affectedRepositories = $repositories->filter(function($repository) use ($commitDto) {
            // check which repositories are affected
            print_r($repository->getComposerName());
            return DependencyTreeService::hasDependency($repository, $commitDto->git_url);
        });

        //print_r($affectedRepositories->getValues());

        return $affectedRepositories;
    }

    public function getAll() : ArrayCollection
    {
        $items = $this->repositoryRepository->getAll();
        
        if (count($items) > 0) {
            return new ArrayCollection($items);
        }

        return $this->repositoryRepository->createRepositories();
    }

    public function getByGitPath(string $gitPath) : Repository
    {
        return $this->repositoryRepository->getByGitPath($gitPath);
    }

    
}