<?php

namespace Ampliffy\CiCd\Domain\Services;

use Ampliffy\CiCd\Domain\Dto\CommitDto;
use Ampliffy\CiCd\Domain\Entities\Commit;
use Doctrine\Common\Collections\Collection;
use Ampliffy\CiCd\Domain\Repositories\CommitRepositoryInterface;

class CommitService
{
    public function __construct(
        protected CommitRepositoryInterface $commitRepository,
        protected RepositoryService $repositoryService
    ) {}

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