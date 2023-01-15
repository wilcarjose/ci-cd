<?php

declare(strict_types = 1);

namespace Ampliffy\CiCd\Domain\Repositories;

use Ampliffy\CiCd\Domain\Dto\CommitDto;
use Ampliffy\CiCd\Domain\Entities\Commit;
use Doctrine\Common\Collections\Collection;
use Ampliffy\CiCd\Domain\Entities\Repository;

interface CommitRepositoryInterface
{
    public function store(CommitDto $commitDto, Repository $repository) : Commit;

    public function attachAffectedRepositories(Commit $commit, Collection $affectedRepositories);
}