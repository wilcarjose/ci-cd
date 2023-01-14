<?php

declare(strict_types = 1);

namespace Ampliffy\CiCd\Entities;

use Doctrine\ORM\Mapping as ORM;
use Ampliffy\CiCd\Collections\RepositoryCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="commits")
 */
class Commit
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length="40")
     */
    private string $hash;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length="100")
     */
    private string $branch;

    /**
     * @var Repository
     *
     * @ORM\ManyToOne(targetEntity=Repository::class)
     * @ORM\JoinColumn(name="repository_id", referencedColumnName="id")
     */
    private Repository $repository;

    /**
     * 
     * Repositories affected by it.
     * @var RepositoryCollection<Repository>
     * 
     * @ORM\ManyToMany(targetEntity="Repository")
     * @ORM\JoinTable(name="affected_repositories",
     *   joinColumns={
     *    @ORM\JoinColumn(name="commit_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *    @ORM\JoinColumn(name="repository_id", referencedColumnName="id")
     *   }
     * )
     * 
     */
    private RepositoryCollection $affectedRepositories;

    public function __construct() {
        $this->affectedRepositories = new RepositoryCollection();
    }

    /**
     * Get the value of id
     *
     * @return  int
     */ 
    public function getId() : int
    {
        return $this->id;
    }

    /**
     * Get the value of hash
     *
     * @return  string
     */ 
    public function getHash() : string
    {
        return $this->hash;
    }

    /**
     * Set the value of hash
     *
     * @param  string  $hash
     *
     * @return  self
     */ 
    public function setHash(string $hash) : self
    {
        $this->hash = $hash;

        return $this;
    }

    /**
     * Get the value of branch
     *
     * @return  string
     */ 
    public function getBranch() : string
    {
        return $this->branch;
    }

    /**
     * Set the value of branch
     *
     * @param  string  $branch
     *
     * @return  self
     */ 
    public function setBranch(string $branch) : self
    {
        $this->branch = $branch;

        return $this;
    }

    /**
     * Get the value of repository
     *
     * @return  Repository
     */ 
    public function getRepository() : Repository
    {
        return $this->repository;
    }

    /**
     * Set the value of repository
     *
     * @param  Repository  $repository
     *
     * @return  self
     */ 
    public function setRepository(Repository $repository) : self
    {
        $this->repository = $repository;

        return $this;
    }

    /**
     * Get repositories affected by it.
     *
     * @return  RepositoryCollection<Repository>
     */ 
    public function getAffectedRepositories() : RepositoryCollection
    {
        return $this->affectedRepositories;
    }
}