<?php

declare(strict_types = 1);

namespace Ampliffy\CiCd\Infrastructure\Repositories;

use Ampliffy\CiCd\Domain\Dto\CommitDto;
use Ampliffy\CiCd\Domain\Entities\Commit;
use Doctrine\Common\Collections\Collection;
use Ampliffy\CiCd\Domain\Repositories\CommitRepositoryInterface;
use Ampliffy\CiCd\Domain\Entities\Repository;

class CommitDoctrineRepository extends BaseDoctrineRepository implements CommitRepositoryInterface
{
    public function store(CommitDto $commitDto, Repository $repository) : Commit
    {
        $commit = (new Commit)
            ->setRepository($repository)
            ->setBranch($commitDto->branch)
            ->setHash($commitDto->commit_id);

        $this->em->persist($commit);
        $this->em->flush();

        return $commit;
    }

    public function attachAffectedRepositories(Commit $commit, Collection $affectedRepositories)
    {
        return $affectedRepositories->filter(function($repository) use ($commit) {
            $commit->addAffectedRepository($repository);
            $this->em->persist($commit);
            $this->em->flush();
        });
    }
}