<?php

namespace Ampliffy\CiCd\Domain\Services;

use Ampliffy\CiCd\Infrastructure\Log;
use Ampliffy\CiCd\Domain\Entities\Repository;
use Doctrine\Common\Collections\ArrayCollection;
use Ampliffy\CiCd\Domain\Exceptions\ComposerException;
use Ampliffy\CiCd\Domain\Repositories\RepositoryRepositoryInterface;

class DependencyTreeService
{
    public function __construct(
        protected ComposerJsonService $composerJsonService,
        protected RepositoryRepositoryInterface $repositoryRepository
    ) {}

    public function hasDependency(Repository $repository, string $gitPath) : bool
    {
        $this->refreshDependencies($repository);
        $repositoryUpdated = $this->repositoryRepository->getByGitPath($gitPath);

        if (is_null($repositoryUpdated)) {
            return false;
        }

        return $this->existsDependency($repository->getDependencies(), $repositoryUpdated);
    }

    public function refreshDependencies($repository)
    {
        if ($repository->hasNotBeenAnalyzed()) {
            return $this->generateDependenciesFromComposerJson($repository);
        }

        // Gets the modification time of the composer.json file located in the repository path
        $fileModifiedAt = $this->composerJsonService->composerFileModifiedAt($repository->getGitPath());

        // if the file has a different date than the last saved, 
        // some new library may have been added to the composer.json
        if ($repository->hasDifferentComposerModifiedAt($fileModifiedAt)) {
            return $this->generateDependenciesFromComposerJson($repository);
        }

        if ($repository->hasNoDependencies()) {
            return new ArrayCollection();
        }        

        $repository->getDependencies()->map(
            fn ($dependency) => $this->refreshDependencies($dependency)
        );

        return $repository->getDependencies();
    }

    public function generateDependenciesFromComposerJson($repository)
    {
        try {
            $composerDependencies = $this->composerJsonService->librariesRequired($repository->getGitPath());
        } catch (ComposerException $e) {
            Log::debug($e->getMessage());
            return new ArrayCollection();
        }

        $composerDependencies->map(function($composerName) use ($repository) {
            $dependency = $this->repositoryRepository->getByComposerName($composerName);
            // it added only if they are in the directories listing
            if ($dependency) {
                $repository->addDependency($dependency);
            }
        });

        $fileModifiedAt = $this->composerJsonService->composerFileModifiedAt($repository->getGitPath());
        $repository->setComposerModifiedAt($fileModifiedAt);
        $this->repositoryRepository->update($repository);

        return $repository->getDependencies();
    }

    public function existsDependency($directDependencies, $repositoryUpdated) : bool
    {
        if ($directDependencies->isEmpty()) {
            return false;
        }

        foreach ($directDependencies as $dependency) {
            if ($dependency->getId() === $repositoryUpdated->getId()) {
                return true;
            }

            if ($this->existsDependency($dependency->getDependencies(), $repositoryUpdated)) {
                return true;
            }
        }

        return false;
    }

}