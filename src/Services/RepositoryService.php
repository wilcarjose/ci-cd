<?php

namespace Ampliffy\CiCd\Services;

use Ampliffy\CiCd\Dto\CommitDto;
use Ampliffy\CiCd\Collections\RepositoryCollection;
use Ampliffy\CiCd\Entities\Repository;

class RepositoryService
{
    public function getAffectedByCommit(CommitDto $commitDto) : RepositoryCollection
    {
        $repositories = $this->getAll();

        $affectedRepositories = $repositories->filter(function($element) {
            // check which repositories are affected
            return $element;
        });

        return $affectedRepositories;
    }

    public function getAll() : RepositoryCollection
    {
        $items = new RepositoryCollection();

        $items->add(new Repository);
        $items->add(new Repository);
        $items->add(new Repository);

        return $items;
    }
}