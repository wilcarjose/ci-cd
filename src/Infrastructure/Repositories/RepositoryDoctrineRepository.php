<?php

declare(strict_types = 1);

namespace Ampliffy\CiCd\Infrastructure\Repositories;

use Ampliffy\CiCd\Domain\Entities\Repository;
use Doctrine\Common\Collections\ArrayCollection;
use Ampliffy\CiCd\Domain\Repositories\RepositoryRepositoryInterface;

class RepositoryDoctrineRepository extends BaseDoctrineRepository implements RepositoryRepositoryInterface
{
    public function getAll()
    {
        $qb = $this->em->createQueryBuilder();

        return $qb->select('r')
            ->from(Repository::class, 'r')
            ->getQuery()
            ->getResult();
    }

    public function createRepositories()
    {
        $items = new ArrayCollection();
        
        $repo1 = (new Repository)
            ->setComposerName('ampliffy/library-1')
            ->setGitPath('/home/code/ampliffy/library_1')
            ->setType('library');

        $this->em->persist($repo1);
        $items->add($repo1);
        
        $repo2 = (new Repository)
            ->setComposerName('ampliffy/library-2')
            ->setGitPath('/home/code/ampliffy/library_2')
            ->setType('library');

        $this->em->persist($repo2);
        $items->add($repo2);

        $repo3 = (new Repository)
            ->setComposerName('ampliffy/project-1')
            ->setGitPath('/home/code/ampliffy/project_3')
            ->setType('project');

        $this->em->persist($repo3);
        $items->add($repo3);

        $this->em->flush();

        return $items;
    }

    public function getByGitPath(string $gitPath) : Repository
    {
        $qb = $this->em->createQueryBuilder();

        return $qb->select('r')
            ->from(Repository::class, 'r')
            ->where('r.gitPath = ?1')
            ->setParameter(1, $gitPath)
            ->setMaxResults(1)
            ->getQuery()
            ->getSingleResult();
    }
}