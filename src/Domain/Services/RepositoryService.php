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
        protected ComposerJsonService $composerJsonService
    ) {}

    public function getAffectedByCommit(CommitDto $commitDto) : Collection
    {
        $repositories = $this->getAll();

        $affectedRepositories = $repositories->filter(function($repository) use ($commitDto) {
            // check which repositories are affected
            return $this->dependencyTreeService->hasDependency($repository, $commitDto->git_url);
        });

        return $affectedRepositories;
    }

    public function getAll() : ArrayCollection
    {
        $directories = $this->getDirectoriesNamesFromBasePath();

        $directories->map(function ($folder) {

            try {

                if ($this->repositoryRepository->doesNotExistByGitPath($folder)) {
                    $composerData = $this->composerJsonService->getComposerContent($folder);
                    $this->repositoryRepository->createRepository(RepositoryDto::fromComposerJson($composerData, $folder));
                }

            } catch (DoesNotExistComposerFileException $e) {
                Log::debug($e->getMessage());
            }

        });

        return $this->repositoryRepository->getAll();
    }

    public function getByGitPath(string $gitPath) : Repository|null
    {
        return $this->repositoryRepository->getByGitPath($gitPath);
    }

    protected function getDirectoriesNamesFromBasePath() : ArrayCollection
    {
        $directories = scandir($_ENV['BASE_PATH']);

        if ($directories === false) {
            return new ArrayCollection();
        }

        return (new ArrayCollection($directories))->filter(fn ($dir) => $this->isDirectory($dir));
    }

    protected function isDirectory($name) : bool
    {
        return is_dir($_ENV['BASE_PATH'] . $name);
    }
}