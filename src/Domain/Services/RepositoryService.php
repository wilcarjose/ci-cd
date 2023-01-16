<?php

namespace Ampliffy\CiCd\Domain\Services;

use Ampliffy\CiCd\Infrastructure\Log;
use Ampliffy\CiCd\Domain\Dto\CommitDto;
use Ampliffy\CiCd\Domain\Dto\RepositoryDto;
use Doctrine\Common\Collections\Collection;
use Ampliffy\CiCd\Domain\Entities\Repository;
use Doctrine\Common\Collections\ArrayCollection;
use Ampliffy\CiCd\Domain\Exceptions\DoesNotExistComposerFileException;
use Ampliffy\CiCd\Domain\Services\ComposerJsonService;
use Ampliffy\CiCd\Domain\Repositories\RepositoryRepositoryInterface;

class RepositoryService
{
    public function __construct(
        protected RepositoryRepositoryInterface $repositoryRepository,
        protected DependencyTreeService $dependencyTreeService,
        protected ComposerJsonService $composerJsonService,
        protected DirectoryService $directoryService
    ) {}

    public function getAffectedByCommit(CommitDto $commitDto) : Collection
    {
        $repositories = $this->getAll();

        $affectedRepositories = $repositories->filter(function($repository) use ($commitDto) {
            // check which repositories are affected
            return $this->dependencyTreeService->hasDependency($repository, $commitDto->git_path);
        });

        return $affectedRepositories;
    }

    public function getAll() : ArrayCollection
    {
        $directories = $this->directoryService->getDirectoriesNamesFromBasePath();

        $directories->map(function ($directory) {

            try {

                if ($this->repositoryRepository->doesNotExistByGitPath($directory)) {
                    $composerData = $this->composerJsonService->getComposerContent($directory);
                    $this->repositoryRepository->createRepository(RepositoryDto::fromComposerJson($composerData, $directory));
                }

            } catch (DoesNotExistComposerFileException $e) {
                //Log::debug($e->getMessage());
            }

        });

        return $this->repositoryRepository->getAll();
    }

    public function getByGitPath(string $gitPath) : Repository|null
    {
        return $this->repositoryRepository->getByGitPath($gitPath);
    }
}