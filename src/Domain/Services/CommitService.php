<?php

namespace Ampliffy\CiCd\Domain\Services;

use Ampliffy\CiCd\Domain\Repositories\CommitRepositoryInterface;
use Ampliffy\CiCd\Domain\Dto\CommitDto;
use Ampliffy\CiCd\Domain\Entities\Commit;
use Ampliffy\CiCd\Domain\Entities\Repository;
use Ampliffy\CiCd\Infrastructure\EntityManager;
use Doctrine\Common\Collections\Collection;

class CommitService
{
    public function __construct(protected CommitRepositoryInterface $commitRepository, protected RepositoryService $repositoryService)
    {

    }

    public function store(CommitDto $commitDto) : Commit
    {
        $repository = $this->repositoryService->getByGitPath($commitDto->git_url);
        return $this->commitRepository->store($commitDto, $repository);
    }

    public function attachAffectedRepositories(Commit $commit, Collection $affectedRepositories)
    {
        return $this->commitRepository->attachAffectedRepositories($commit, $affectedRepositories);
    }
}