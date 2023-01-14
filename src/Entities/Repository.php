<?php

declare(strict_types = 1);

namespace Ampliffy\CiCd\Entities;

use Doctrine\ORM\Mapping as ORM;
use Ampliffy\CiCd\Collections\RepositoryCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="repositories")
 */
class Repository
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
     * @ORM\Column(type="string", name="composer_name")
     */
    private string $composerName;

    /**
     * @var string
     *
     * @ORM\Column(type="string", name="git_path")
     */
    private string $gitPath;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private string $type;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", name="composer_modified_at")
     */
    private int|null $composerModifiedAt;

    /**
     * 
     * Repositories where it is used.
     * @var RepositoryCollection<Repository>
     * 
     * @ORM\ManyToMany(targetEntity=Repository::class, mappedBy="dependencies")
     */
    private RepositoryCollection $usedIn;

    /**
     * 
     * Repositories it depends on.
     * @var RepositoryCollection<Repository>
     * 
     * @ORM\ManyToMany(targetEntity="Repository", inversedBy="usedIn")
     * @ORM\JoinTable(name="dependency_tree",
     *   joinColumns={
     *    @ORM\JoinColumn(name="repository_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *    @ORM\JoinColumn(name="dependency_id", referencedColumnName="id")
     *   }
     * )
     * 
     */
    private RepositoryCollection $dependencies;

    public function __construct() {
        $this->usedIn = new RepositoryCollection();
        $this->dependencies = new RepositoryCollection();
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
     * Get the value of composerName
     *
     * @return  string
     */ 
    public function getComposerName() : string
    {
        return $this->composerName;
    }

    /**
     * Set the value of composerName
     *
     * @param  string  $composerName
     *
     * @return  self
     */ 
    public function setComposerName(string $composerName) : self
    {
        $this->composerName = $composerName;

        return $this;
    }

    /**
     * Get the value of gitPath
     *
     * @return  string
     */ 
    public function getGitPath() : string
    {
        return $this->gitPath;
    }

    /**
     * Set the value of gitPath
     *
     * @param  string  $gitPath
     *
     * @return  self
     */ 
    public function setGitPath(string $gitPath) : self
    {
        $this->gitPath = $gitPath;

        return $this;
    }

    /**
     * Get the value of type
     *
     * @return  string
     */ 
    public function getType() : string
    {
        return $this->type;
    }

    /**
     * Set the value of type
     *
     * @param  string  $type
     *
     * @return  self
     */ 
    public function setType(string $type) : self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get the value of composerModifiedAt
     *
     * @return  int
     */ 
    public function getComposerModifiedAt() : int|null
    {
        return $this->composerModifiedAt;
    }

    /**
     * Set the value of composerModifiedAt
     *
     * @param  int  $composerModifiedAt
     *
     * @return  self
     */ 
    public function setComposerModifiedAt(int|null $composerModifiedAt) : self
    {
        $this->composerModifiedAt = $composerModifiedAt;

        return $this;
    }

    /**
     * Get repository where it is used>
     *
     * @return  RepositoryCollection,
     */ 
    public function getUsedIn() : RepositoryCollection
    {
        return $this->usedIn;
    }

    /**
     * Get repositories it depends on.
     *
     * @return  RepositoryCollection
     */ 
    public function getDependencies() : RepositoryCollection
    {
        return $this->dependencies;
    }

}