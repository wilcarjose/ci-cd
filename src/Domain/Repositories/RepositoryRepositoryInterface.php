<?php

declare(strict_types = 1);

namespace Ampliffy\CiCd\Domain\Repositories;

use Ampliffy\CiCd\Domain\Entities\Repository;

interface RepositoryRepositoryInterface
{
    public function getAll();

    public function createRepositories();

    public function getByGitPath(string $gitPath) : Repository;
}