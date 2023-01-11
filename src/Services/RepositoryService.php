<?php

namespace Ampliffy\CiCd\Services;

use Ampliffy\CiCd\Dto\CommitDto;

class RepositoryService
{
    public function getAffectedByCommit(CommitDto $commitDto)
    {
        print_r($commitDto->toArray());
        return;
    }
}