<?php

declare(strict_types = 1);

namespace Ampliffy\CiCd\Domain\Repositories;

use Ampliffy\CiCd\Domain\Dto\RepositoryDto;
use Ampliffy\CiCd\Domain\Entities\Repository;

interface RepositoryRepositoryInterface
{
    public function getAll();

    public function getByGitPath(string $gitPath) : Repository|null;

    public function getByComposerName(string $composerName) : Repository|null;

    public function update(Repository $repository) : Repository;

    public function createRepository(RepositoryDto $repositoryDto) : Repository;

    public function doesNotExistByGitPath(string $gitPath) : bool;
}